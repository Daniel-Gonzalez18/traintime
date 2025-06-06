<script setup lang="ts">
import Cabecera from '@/components/Cabecera.vue';
import PieDePagina from '@/components/PieDePagina.vue';
const props = defineProps<{
  grupos: Array<any>,
}>();
</script>
<template>
  <div class="flex justify-center bg-black w-full h-20">
    <Cabecera :enlaces="[
      { titulo: 'CALENDARIO', href: 'calendario' },
      { titulo: 'RUTINA', href: 'rutina' },
      { titulo: 'PROGRESO', href: 'progreso' },
      { titulo: 'INICIO', href: 'home' }
    ]" />
  </div>
  <section class="bg-black w-screen">
    <div class="p-5">
      <a class="text-[#43A047] absolute right-5 " href="/create/group">CREAR GROUPO +</a>
    </div>
    <div class=" bg-black w-screen h-40 flex justify-center " v-if="grupos.length == 0">
      <p class="text-white text-xl">Todavia no perteneces a ningun grupo, puedes crearlo o que tus amigos te unan a sus
        grupos
      </p>
    </div>
    <div class="bg-black w-screen flex p4-" v-else>
      <p class="text-white">Lista de grupos :</p>

      <li class="text-white" v-for="grupo in grupos" :key="grupo.id">
        {{ grupo.name }} ({{ grupo.pivot.role }})
      </li>
    </div>
  </section>
  <PieDePagina />
</template>
