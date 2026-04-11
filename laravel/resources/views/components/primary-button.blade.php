<button {{ $attributes->merge([
'type' => 'submit',
'class' => '
w-full justify-center
px-4 py-3
bg-[#e9c38c]
text-black
font-semibold
rounded-lg
uppercase tracking-widest text-xs
hover:scale-[1.02]
hover:shadow-lg hover:shadow-[#e9c38c]/20
transition-all duration-300
'
]) }}>
    {{ $slot }}
</button>
