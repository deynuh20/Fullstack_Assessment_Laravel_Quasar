<template>
  <q-layout view="lHh Lpr lFf">
    <q-toolbar class="custom-toolbar q-mb-md">
      <div class="text-h6 text-weight-medium">Product Manager</div>
      <q-space />
    </q-toolbar>
  <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({ name: 'MainLayout' });
</script>
  