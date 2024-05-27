<ul class="rounded-lg border py-4 flex flex-col items-center w-full">
    @for ($i = 0; $i < 3; $i++)
        <li class="text-blue-800">
            - File {{ $i }}
        </li>
    @endfor
    <button class="bg-blue-800 text-white rounded-md py-2 w-1/3">Ajouter <input type="file" name="file" class="invisible w-full"></button>
</ul>