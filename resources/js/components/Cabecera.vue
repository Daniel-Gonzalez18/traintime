<script setup lang="ts">
import AppLogoIcon from './AppLogoIcon.vue';

interface Enlace {
  titulo: string;
  href: string;
}

const props = defineProps<{
  enlaces: Enlace[];
}>();

const mitad = Math.ceil(props.enlaces.length / 2);
const enlacesIzquierda = props.enlaces.slice(0, mitad);
const enlacesDerecha = props.enlaces.slice(mitad);
</script>

<template>
  <!-- <nav class="bg-[#D9D9D9]"> -->
  <nav class="enlaces">
    <a class="hover:text-[#FFFFFF]" v-for="(enlace, index) in enlacesIzquierda" :key="'izq-' + index"
      :href="route(enlace.href)">
      {{ enlace.titulo }}
    </a>
    <AppLogoIcon class="logo" />
    <a class="hover:text-[#FFFFFF]" v-for="(enlace, index) in enlacesDerecha" :key="'der-' + index"
      :href="route(enlace.href)">
      {{ enlace.titulo }}
    </a>
    <!-- </nav>

    <div class="logo">
      <AppLogoIcon />
    </div>

    <nav class="enlaces">
      <a v-for="(enlace, index) in enlacesDerecha" :key="'der-' + index" :href="route(enlace.href)">
        {{ enlace.titulo }}
      </a> -->
  </nav>

</template>

<style scoped>
/* template {
  width: 80%;
  margin: 0 auto;
  background-color: #d9d9d9;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  position: relative;
} */
/* 
.logo {
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  z-index: 10;
} */

.enlaces {
  display: flex;
  justify-content: space-around;
  align-items: center;
  gap: 1rem;
  width: 80%;

  background-color: #D9D9D9;
  text-align: center;
  font-weight: bold;
  font-size: large;
}

.logo {
  width: 80px;
  height: 80px;
}
</style>
