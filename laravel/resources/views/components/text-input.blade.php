@props(['disabled' => false])

<input {{ $attributes->merge([
'class' => '
w-full mt-1
bg-[#0f1115]
border border-[#242833]
rounded-lg
px-4 py-3
text-white
placeholder-gray-500
focus:border-[#e9c38c]
focus:ring-[#e9c38c]/20
transition
'
]) }}>