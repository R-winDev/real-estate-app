@props(['active' => false])

<a {{ $attributes->merge(['class' => 'block w-full pr-3 pl-4 py-2 border-r-4 text-start text-base font-medium transition duration-150 ease-in-out ' . ($active ? 'border-brand-500 text-brand-700 bg-brand-50 focus:outline-none focus:text-brand-800 focus:bg-brand-100 focus:border-brand-700' : 'border-transparent text-surface-600 hover:text-surface-800 hover:bg-surface-50 hover:border-surface-300 focus:outline-none focus:text-surface-800 focus:bg-surface-50 focus:border-surface-300')]) }}>
    {{ $slot }}
</a>
