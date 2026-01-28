<x-app-layout>
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-skin-text">Record Transaction</h2>
            <a href="{{ route('admin.transactions.index') }}" class="text-skin-text-muted hover:text-skin-text">Back to Transactions</a>
        </div>

        <div class="bg-skin-base border border-skin-border rounded-lg shadow-sm p-6">
            <form action="{{ route('admin.transactions.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Investor -->
                <div>
                    <label for="user_id" class="block text-sm font-medium text-skin-text-muted">Investor</label>
                    <select name="user_id" id="user_id" required
                        class="mt-1 block w-full rounded-md border-skin-border shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm bg-skin-fill text-skin-text">
                        <option value="">Select Investor</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-skin-text-muted">Transaction Type</label>
                    <select name="type" id="type" required
                        class="mt-1 block w-full rounded-md border-skin-border shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm bg-skin-fill text-skin-text">
                        <option value="deposit">Deposit</option>
                        <option value="withdrawal">Withdrawal</option>
                        <option value="investment">Investment</option>
                        <option value="distribution">Distribution</option>
                    </select>
                </div>

                <!-- Amount -->
                <div>
                    <label for="amount" class="block text-sm font-medium text-skin-text-muted">Amount</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-skin-text-muted sm:text-sm">₦</span>
                        </div>
                        <input type="number" name="amount" id="amount" step="0.01" min="0" required
                            class="focus:ring-umera-500 focus:border-umera-500 block w-full pl-7 pr-12 sm:text-sm border-skin-border rounded-md bg-skin-fill text-skin-text" placeholder="0.00">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-skin-text-muted sm:text-sm">NGN</span>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-skin-text-muted">Description</label>
                    <textarea name="description" id="description" rows="3"
                        class="mt-1 block w-full rounded-md border-skin-border shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm bg-skin-fill text-skin-text"></textarea>
                </div>

                <!-- Reference (Optional) -->
                <div>
                    <label for="reference" class="block text-sm font-medium text-skin-text-muted">Reference / Transaction ID</label>
                    <input type="text" name="reference" id="reference"
                        class="mt-1 block w-full rounded-md border-skin-border shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm bg-skin-fill text-skin-text">
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-skin-text-muted">Status</label>
                    <select name="status" id="status" required
                        class="mt-1 block w-full rounded-md border-skin-border shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm bg-skin-fill text-skin-text">
                        <option value="completed">Completed</option>
                        <option value="pending">Pending</option>
                        <option value="failed">Failed</option>
                    </select>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-umera-600 hover:bg-umera-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-umera-500">
                        Record Transaction
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>