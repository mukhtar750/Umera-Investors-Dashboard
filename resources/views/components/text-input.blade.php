@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-umera focus:ring-umera rounded-md shadow-sm']) }}>
