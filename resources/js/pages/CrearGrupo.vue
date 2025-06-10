<!-- <script setup lang="ts">
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
</template> -->
<script setup lang="ts">
import { reactive, ref } from 'vue'
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')

const form = reactive({
    nombre: '',
    emails: '',
    descripcion: ''
})

const errores = reactive({
    nombre: '',
    emails: '',
    descripcion: ''
})

const enviado = ref(false);

function validarEmail(email: string) {
    return /^[a-zA-Z0-9._%+-]+@gmail\.com$/i.test(email);
}

function validarFormulario(e: Event) {
    errores.nombre = ''
    errores.emails = ''
    errores.descripcion = ''
    enviado.value = false;

    if (!form.nombre.trim()) {
        errores.nombre = 'El nombre es obligatorio'
    } else if (form.nombre.length > 32) {
        errores.nombre = 'Máximo 32 caracteres'
    }
    const listaEmails = form.emails.split(',').map(mail => mail.trim()).filter(mail => mail !== '')
    if (!form.emails.trim()) {
        errores.emails = 'Introduce al menos un email'
    } else if (listaEmails.length === 0) {
        errores.emails = 'Introduce al menos un email'
    } else if (listaEmails.some(email => !validarEmail(email))) {
        errores.emails = 'Todos los emails deben ser válidos'
    }

    if (form.descripcion.length > 100 || form.descripcion.length == 0) {
        errores.descripcion = 'Máximo 100 caracteres'
    }
    if (errores.nombre || errores.emails || errores.descripcion) {
        e.preventDefault()
    } else {
        enviado.value = true
    }
}
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
            <form action="/group/store" method="post"
                class="flex flex-col gap-6 w-full max-w-xl bg-[#181818] rounded-xl p-8 shadow-xl"
                @submit="validarFormulario">
                <input type="hidden" name="_token" :value="csrfToken" />
                <div class="flex flex-col gap-1">
                    <label for="nombre" class="text-lg font-medium">Nombre del grupo</label>
                    <input v-model="form.nombre" type="text" name="nombre" id="nombre"
                        class="bg-black text-white border border-white rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#fff6]"
                        maxlength="32" autocomplete="off" required />
                    <span v-if="errores.nombre" class="text-red-400 text-xs mt-1">{{ errores.nombre }}</span>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="emails" class="text-lg font-medium">
                        Emails de los componentes (separados por coma, sin poner el suyo)
                    </label>
                    <input v-model="form.emails" type="text" name="emails" id="emails"
                        class="bg-black text-white border border-white rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#fff6]"
                        autocomplete="off" required />
                    <span v-if="errores.emails" class="text-red-400 text-xs mt-1">{{ errores.emails }}</span>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="descripcion" class="text-lg font-medium">Descripción del grupo</label>
                    <input v-model="form.descripcion" type="text" name="descripcion" id="descripcion"
                        class="bg-black text-white border border-white rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#fff6]"
                        maxlength="100" autocomplete="off" />
                    <span v-if="errores.descripcion" class="text-red-400 text-xs mt-1">{{ errores.descripcion }}</span>
                </div>

                <button type="submit"
                    class="bg-white text-black font-bold py-2 w-32 rounded hover:bg-gray-200 self-start">
                    Crear
                </button>

                <div v-if="enviado" class="text-green-400 mt-2">¡Grupo enviado correctamente!</div>
            </form>
        </div>
    </section>
</template>
