<script setup lang="ts">
import Cabecera from '@/components/Cabecera.vue';
import fondo from './../../imagenes/ryan-hoffman-kkVAhFEZCWk-unsplash1.jpg';
import PieDePagina from '@/components/PieDePagina.vue';
</script>

<template>
  <header class="w-full h-screen bg-center bg-cover bg-fixed
 flex flex-col justify-center items-center object-cover relative
" :style="{ backgroundImage: `url(${fondo})` }">
    <Cabecera class=" top-0 fixed" :enlaces="[
      { titulo: 'CALENDARIO', href: 'calendario' },
      { titulo: 'RUTINA', href: 'rutina' },
      { titulo: 'PROGRESO', href: 'progreso' },
      { titulo: 'GRUPO', href: 'grupo' }
    ]" />
    <div class="text-[#67FAFF] font-bold text-5xl">LA IA QUE ENTIENDE TU CUERPO</div>
    <div class="text-white font-bold text-3xl mt-10 w-3/5 text-center">Planifica, entrena y progresa con una herramienta
      que combina
      inteligencia artificial y apoyo comunitario para maximizar tus resultados</div>
  </header>
  <section class="w-full flex bg-black pt-4 pb-4">
    <div class="flex flex-col  w-1/2 text-center items-center justify-around ">
      <div class=" text-[#67FAFF] text-4xl font-bold">CADA RUTINA ES UNICA</div>
      <div class=" w-3/4 text-white text-3xl font-bold mb-4">Consigue una rutina de entrenamiento personalizada para ti
        , generada
        por una
        Inteligencia
        Artificial que se ajusta a las condiciones de cada usuario
      </div>
    </div>
    <div class="flex w-1/2 justify-center"><img class="w-4/6"
        src="./../../imagenes/luke-witter-k47w6BeapCs-unsplash1.jpg" alt="">
    </div>
  </section>
  <section class="w-full flex bg-black pt-4 pb-4">

    <div class="flex w-1/2 justify-center"><img class="w-4/6"
        src="./../../imagenes/victor-freitas-WvDYdXDzkhs-unsplash1.jpg" alt=""></div>
    <div class="flex flex-col  w-1/2 text-center items-center justify-around">
      <div class="text-[#67FAFF] text-4xl font-bold">CALENDARIO DE RUTINA </div>
      <div class=" w-3/4 text-white text-3xl font-bold mb-4">Almacena tu rutina de entrnamiento en una aplicacion de
        calendario comoda para todo los usuarios y facil de acceder
      </div>
    </div>
  </section>
  <section class="w-full flex bg-black pt-4 pb-4">
    <div class="flex flex-col  w-1/2 text-center items-center justify-around">
      <div class="text-[#67FAFF] text-4xl font-bold">VISUALIZA LOS PROGRESOS</div>
      <div class="w-3/4 text-white text-3xl font-bold mb-4">Puedes ir viendo los progresos de cada ejercicio en cada dia
        de entrenamiento y puedes competir con tus amigos por ver quien progresa mas
      </div>
    </div>
    <div class="flex w-1/2 justify-center"><img class="w-4/6"
        src="./../../imagenes/anastase-maragos-7kEpUPB8vNk-unsplash1.jpg" alt=""></div>
  </section>
  <PieDePagina />
</template>
