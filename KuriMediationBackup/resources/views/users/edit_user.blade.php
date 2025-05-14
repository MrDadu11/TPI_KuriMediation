
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    {{-- Icons for edit and delete --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Modifier</title>
</head>
<body>
    <x-app-layout>
        <div class="bg-white border md:mt-10 max-w-full md:max-w-7xl mx-auto px-4 py-2 md:px-5 xl:px-10 xl:py-8 rounded-xl">
            <a href="{{ route('user.index') }}" class="bg-blue-800 text-white border px-3 py-2 rounded-lg font-extrabold text-lg hover:bg-blue-600 transition ease-in-out duration-300">
                Retour
            </a>
            <section class="mt-3">
                <div class="px-5 py-3 border rounded-lg shadow-xl">
                    {{-- Form that updates the user's informations --}}
                    <form action="{{ route('user.update', $selectedUser->id) }}" method="POST">
                        @csrf
                        <div class="flex justify-between items-start xl:items-center flex-col xl:flex-row space-y-3">
                            <div>
                                <label class="text-xl text-blue-800 font-bold " for="username">Nom d'utilisateur :</label>
                                <input class="rounded-lg border-gray-200 resize-none w-full" id="username" name="username" placeholder="Nom d'utilisateur" value="{{ $selectedUser->username }}" required>
                                <x-input-error class="mt-2" :messages="$errors->get('username')" />
                            </div>
                            <div>
                                <label for="isAdmin" class="font-bold xl:px-3 py-1 text-blue-800 text-lg">Admin:</label>
                                <select name="isAdmin" class="rounded-lg border border-gray-300" required>
                                    <option value="1"{{ $selectedUser->isAdmin == true ? 'selected' : '' }}>oui</option>
                                    <option value="0"{{ $selectedUser->isAdmin == false ? 'selected' : '' }}>non</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('idAdmin')" />
                            </div>
                        </div>
                        <div class="mt-2 flex flex-col xl:flex-row justify-between">
                            <div class="xl:w-1/2">
                                <div>
                                    <label class="text-xl text-blue-800 font-bold " for="firstname">Prénom :</label>
                                    <input type="text" class="rounded-lg border-gray-200 resize-none w-full" id="firstname" name="firstname" placeholder="Prénom" value="{{ $selectedUser->firstname }}" required>
                                    <x-input-error class="mt-2" :messages="$errors->get('firstname')" />
                                </div>
                                <div>
                                    <label class="text-xl text-blue-800 font-bold " for="lastname">Nom :</label>
                                    <input type="text" class="rounded-lg border-gray-200 resize-none w-full" id="lastname" name="lastname" placeholder="Nom" value="{{ $selectedUser->lastname }}" required>
                                    <x-input-error class="mt-2" :messages="$errors->get('lastname')" />
                                </div>
                                <div>
                                    <label class="text-xl text-blue-800 font-bold " for="email">Email :</label>
                                    <input type="text" class="rounded-lg border-gray-200 resize-none w-full" id="email" name="email" placeholder="Email" value="{{ $selectedUser->email }}" required>
                                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                </div>
                                <div>
                                    <label class="text-xl text-blue-800 font-bold " for="password">Mot de passe :</label>
                                    <input type="password" class="rounded-lg border-gray-200 resize-none w-full" id="password" name="password" placeholder="Mot de passe">
                                    <x-input-error class="mt-2" :messages="$errors->get('password')" />
                                </div>
                                <div>
                                    <label class="text-xl text-blue-800 font-bold " for="passwordConfirm">Mot de passe :</label>
                                    <input type="password" class="rounded-lg border-gray-200 resize-none w-full" id="passwordConfirm" name="passwordConfirm" placeholder="Confirmer mot de passe">
                                    <x-input-error class="mt-2" :messages="$errors->get('passwordConfirm')" />
                                </div>
                            </div>
                            <div class="flex justify-center items-center mt-2 xl:mt-0 xl:items-end xl:justify-end xl:w-1/2">
                                <button type="submit" class="rounded-lg px-3 py-1 bg-blue-800 text-white hover:bg-blue-600 h-10 items-center transition ease-in-out duration-150">Sauvegarder</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </x-app-layout>
</body>
</html>
