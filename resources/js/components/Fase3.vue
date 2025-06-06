<script setup lang="ts">
const props = defineProps(['modelValue'])
const validateHorarios = () => {
    for (const dia of props.modelValue.dias) {
        if (!dia.inicio || !dia.fin) {
            alert(`Faltan horas en ${dia.nombre}`);
            return false;
        }

        const inicio = new Date(`1970-01-01T${dia.inicio}:00`);
        const fin = new Date(`1970-01-01T${dia.fin}:00`);

        if (inicio >= fin) {
            alert(`Inicio debe ser antes de fin en ${dia.nombre}`);
            return false;
        }

        const diff = (fin.getTime() - inicio.getTime()) / (1000 * 60 * 60);
        if (diff > 2) {
            alert(`Entrenamiento en ${dia.nombre} no puede durar más de 2 horas`);
            return false;
        }
    }
    return true;
};
defineExpose({ validateHorarios });

</script>
<template>
    <div>
        <h2 class="text-xl font-bold mb-4">Detalles de los dias de entrenamiento</h2>
        <div v-for="(dia, index) in modelValue.dias" :key="index">
            <h3>{{ dia.nombre }}</h3>
            <label>Inicio:
                <input type="time" v-model="modelValue.dias[index].inicio" />
            </label>
            <label>Fin:
                <input type="time" v-model="modelValue.dias[index].fin" />
            </label>
        </div>

    </div>
</template>
