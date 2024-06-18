<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>A Propos</title>
</head>
<body>
    <x-app-layout>
        <div class="bg-white shadow-2xl border md:mt-10 max-w-full md:max-w-7xl md:min-h-full mx-auto px-4 py-2 md:py-6 md:px-8 xl:px-10 rounded-xl">
            <div class="p-3 md:px-6 space-y-5">
                <section class="border shadow-lg rounded-xl py-12 text-justify px-8">
                    <h1 class="font-bold text-2xl flex justify-center mb-4">A propos</h1>                    
                    <div class="text-lg justify-center xl:mx-40">
                        <p>KuriMediation est une application web servant à faciliter la gestion de cas de médiations. Cette application est développée pendant la période du TPI
                            c'est-à-dire, du lundi 13 mai 2024 au lundi 3 juin 2024. Elle a été développée par Chris Suboonsan de la classe FIN2. L'application est codée en PHP avec le framework Laravel et des packages supplémentaires tels que Breeze et Tailwind CSS ( inclut dans Breeze ). </p>
                    </div>
                </section>
                <section class="bg-white border border-gray-300 shadow-2xl rounded-xl py-12 px-3 text-justify">
                    <h1 class="font-bold text-2xl flex justify-center mb-4">Personnes suivants le projet</h1>                    
                    <div class="flex justify-between text-center md:px-3 xl:space-x-5 flex-col md:flex-row">
                        <div class="border border-gray-300 shadow-lg rounded-xl px-5 py-2 flex-1 h-36 flex justify-center flex-col">
                            <div class="font-bold">
                                Candidat
                            </div>
                            <div>
                                Chris Suboonsan
                            </div>
                        </div>
                        <div class="border border-gray-300 shadow-lg rounded-xl px-5 py-2 flex-1 h-36 flex justify-center flex-col text-red-600">
                            <div class="font-bold">
                                Expert 1
                            </div>
                            <div>
                                Nicolas Borboën
                            </div>
                        </div>
                        <div class="border border-gray-300 shadow-lg rounded-xl px-5 py-2 flex-1 h-36 flex justify-center flex-col text-green-500">
                            <div class="font-bold">
                                Expert 2
                            </div>
                            <div>
                                Bernard Oberson
                            </div>
                        </div>
                        <div class="border border-gray-300 shadow-lg rounded-xl px-5 py-2 flex-1 h-36 flex justify-center flex-col text-purple-500">
                            <div class="font-bold">
                                Chef de projet
                            </div>
                            <div>
                                Dimitri Lymberis
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </x-app-layout>
</body>
</html>
