<ul class="rounded-lg border py-4 flex flex-col items-center w-full">
    @for ($i = 0; $i < 3; $i++)
        <li class="text-blue-800">
            - File {{ $i }}
        </li>
    @endfor
    <input type="file" name="file" class="bg-blue-800">
</ul>