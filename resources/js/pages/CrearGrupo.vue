<script setup lang="ts">
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
</script>
<template>
    <section class="">
        <form action="/group/store" method="post">
            <input type="hidden" name="_token" :value="csrfToken" />
            <label for="nombre">Introduce el nombre del grupo que quieras crear</label>
            <input type="text" name="nombre" id="nombre">
            <label for="emails">Introduce los emails de los componontes del grupo separados por coma (no tienes que
                poner el tuyo)</label>
            <input type="text" name="emails" id="emails">
            <label for="descripcion">Introduce una descripcion del grupo</label>
            <input type="text" name="descripcion" id="descripcion">
            <button type="submit">Crear</button>
        </form>
    </section>
</template>