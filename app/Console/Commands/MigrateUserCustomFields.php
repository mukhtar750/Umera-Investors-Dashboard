<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateUserCustomFields extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'investors:migrate-custom-fields';

    protected $description = 'Migrate data from custom_fields to dedicated columns in users table';

    public function handle()
    {
        $users = \App\Models\User::whereNotNull('custom_fields')->get();
        $count = 0;

        $this->info('Found '.$users->count().' users with custom_fields.');
        $bar = $this->output->createProgressBar($users->count());

        foreach ($users as $user) {
            $cf = $user->custom_fields;
            if (! is_array($cf)) {
                continue;
            }

            $updates = [];

            // Mapping of field to possible raw keys in custom_fields
            $mapping = [
                'phone' => ['phone', 'CONTACT', 'contact'],
                'next_of_kin_email' => ['next_of_kin_email', 'next of kin email address', 'nok_email'],
                'next_of_kin_phone' => ['next_of_kin_phone', 'next of kin contact no', 'nok_phone'],
                'next_of_kin_name' => ['next_of_kin_name', 'nok_name'],
                'next_of_kin_relationship' => ['next_of_kin_relationship', 'nok_relationship'],
                'address' => ['address', 'home address'],
                'dob' => ['dob', 'date of birth'],
            ];

            foreach ($mapping as $target => $sources) {
                if (! empty($user->$target)) {
                    continue;
                } // Already set

                foreach ($sources as $source) {
                    // Try exact match or lowercase match
                    $value = $cf[$source] ?? $cf[strtolower($source)] ?? null;
                    if ($value && $value !== 'N/A' && $value !== 'nil') {
                        $updates[$target] = $value;
                        break; // Found one, move to next target
                    }
                }
            }

            if (! empty($updates)) {
                $user->update($updates);
                $count++;
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Successfully migrated data for $count users.");
    }
}
