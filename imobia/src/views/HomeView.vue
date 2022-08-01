<script setup>
import { createApp } from "vue";
import App from '../App.vue'

import Lista from '@/components/Lista.vue'

var eventBus = createApp(App);
</script>

<template>
  <main>
    <Lista />
  </main>
</template>