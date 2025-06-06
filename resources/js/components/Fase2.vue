<script lang="ts" setup>
const diasSemana = ["lunes", "martes", "miercoles", "jueves", "viernes", "sabado", "domingo"]
const toggleDia = (dia: string) => {
    const index = props.modelValue.dias.indexOf(dia);

    if (index === -1 && props.modelValue.dias.length < props.modelValue.numDias) {
        props.modelValue.dias.push(dia);
    } else if (index !== -1) {
        props.modelValue.dias.splice(index, 1);
    }
};

const props = defineProps(['modelValue'])
</script>

<template>
    <section class="flex flex-col">
        <h2 class="text-xl font-bold mb-4">Caracteristicas del entrenamiento</h2>
        <div class="">
            <label for="objetivo">Cual es tu objetivo del entrenamiento</label>
            <select v-model="modelValue.objetivo" name="objetivo" id="objetivo"
                class="p-2 border rounded text-white bg-black">
                <option disabled value=""></option>
                <option value="tonificar">Tonificar</option>
                <option value="ganar_masa_muscular">Ganar masa muscular</option>
                <option value="definicion">Definicion</option>
                <option value="recomposicion">Recomposicion</option>
                <option value="perder_peso">Perder peso</option>
                <option value="volumen">Volumen</option>
            </select>
        </div>
        <div class="">
            <label for="numDias">Numero de dias que quieres entrenar</label>
            <input v-model="modelValue.numDias" type="number" min="1" max="7" name="numDias" id="num_dias">
        </div>
        <div class="">
            <label for="dias">Que {{ modelValue.numDias }} dias quieres ir a entrenar</label>
            <div v-for="dia in diasSemana" :key="dia" class="">
                <input v-model="modelValue.diasSeleccionados" type="checkbox" v-bind:name="dia" v-bind:id="dia"
                    v-bind:value="dia"
                    v-bind:disabled="!modelValue.dias.includes(dia) && modelValue.dias.length >= modelValue.numDias"
                    @change="toggleDia(dia)" />
                <label v-bind:for="dia">{{ dia }}</label>

            </div>
        </div>
    </section>
</template>
