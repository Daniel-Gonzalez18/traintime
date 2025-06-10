<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>
<template>
    <img :class="className" v-bind="$attrs"
        src="./../../imagenes/logo_minimalista_para_una_página_web_de_gimnasio_en_formato_PNG_sin_fondo_y_con_colores_neutros__1_-removebg-preview.png"
        alt="Logo" />
</template>