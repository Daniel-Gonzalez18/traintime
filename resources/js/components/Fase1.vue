<script lang="ts" setup>
defineProps(['modelValue'])
</script>
<template>
    <div class="h-full w-1/2">
        <h2 class="text-xl font-bold mb-4">Caracteristicas del usuario</h2>
        <div class="flex">
            <label for="altura">Altura:</label>
            <input type="number" min="100" max="250" v-model="modelValue.altura" name="altura" id="altura">
            <p> cm</p>
        </div>
        <div class="flex">
            <label for="peso">Peso: </label>
            <input type="number" min="1" max="250" v-model="modelValue.peso" name="peso" id="peso">
            <p> kg</p>
        </div>
        <label for="experiencia">Selecciona tu experiencia</label>
        <select class="p-2 border rounded text-white bg-black" name="experiencia" id="experiencia"
            v-model="modelValue.experiencia">
            <option disabled value=""></option>
            <option value="pricipiante">Principiante</option>
            <option value="intermedio">Intermedio</option>
            <option value="avanzado">Avanzado</option>
        </select>
    </div>
</template>
