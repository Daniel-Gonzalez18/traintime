<script setup lang="ts">
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
</script>
<template>
    <section class="bg-black w-full h-screen text-white">
        <a href="/" class="mt-10 ml-10 inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 12 12">
                <path fill="#fff"
                    d="M10.5 6a.75.75 0 0 0-.75-.75H3.81l1.97-1.97a.75.75 0 0 0-1.06-1.06L1.47 5.47a.75.75 0 0 0 0 1.06l3.25 3.25a.75.75 0 0 0 1.06-1.06L3.81 6.75h5.94A.75.75 0 0 0 10.5 6" />
            </svg>
        </a>
        <div class="flex flex-col w-full h-3/4 justify-center items-center">
            <form action="/group/store" class="flex flex-col justify-center aligns-center" method="post">
                <input type="hidden" name="_token" :value="csrfToken" />
                <div class="">
                    <label for="nombre" class="text-lg">Introduce el nombre del grupo que quieras crear</label>
                    <input type="text" class="ml-5 border rounded" name="nombre" id="nombre">
                </div>
                <div class="">
                    <label for="emails" class="text-lg">Introduce los emails de los componontes del grupo separados por
                        coma (no tienes
                        que
                        poner el tuyo)</label>
                    <input type="text" class="ml-5 border rounded" name="emails" id="emails">
                </div>
                <div class="">
                    <label for="descripcion" class="text-lg">Introduce una descripcion del grupo</label>
                    <input type="text" class="ml-5 border rounded" name="descripcion" id="descripcion">
                </div>
                <button type="submit" class="bg-white text-black font-bold py-2 w-32 rounded hover:bg-gray-200">
                    Crear
                </button>

            </form>
        </div>
    </section>
</template>