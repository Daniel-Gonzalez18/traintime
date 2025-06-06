<script setup lang="ts">
import AppLogoIcon from './AppLogoIcon.vue';


</script>
<template>
    <section class="flex w-full h-80 bg-[#D9D9D9]">
        <div class="w-1/3 flex flex-col ">
            <p class="font-bold text-center text-xl">SOPORTE</p>
            <div class="flex flex-col items-center h-70 justify-around">
                <a class="underline" href="#">REPORTAR UN PROBLEMA</a>
                <a class="underline" href="#">PREGUNTAS FRECUENTES</a>
                <a class="underline" href="#">CONTACTO</a>
                <a class="underline" href="#">AYUDA</a>
            </div>
        </div>
        <div class="w-1/3 flex flex-col items-center">
            <p class="font-bold text-xl">TRAINTIME</p>
            <AppLogoIcon class="w-1/3" />
            <p class="text-xl font-bold">REDES SOCIALES</p>
            <div class="flex justify-between p-4">
                <img class="w-1/6" src="./../../imagenes/Vector (7).png" alt="">
                <img class="w-1/6" src="./../../imagenes/Vector (8).png" alt="">
                <img class="w-1/6" src="./../../imagenes/Vector (9).png" alt="">
                <img class="w-1/6" src="./../../imagenes/Vector (10).png" alt="">
            </div>
        </div>
        <div class="w-1/3 flex flex-col">
            <p class="font-bold text-xl text-center">POLITICA DE PRIVACIDAD TERMINOS Y CONDICIONES</p>
            <div class="flex flex-col h-60 items-center justify-around">
                <a class="underline" href="#">COOKIES</a>
                <a class="underline" href="#">TERMINOS DE USO</a>
                <a class="underline" href="#">PRIVACIDAD</a>
                <a class="underline" href="#">AVISOS LEGALES</a>
            </div>
        </div>
    </section>
</template>
