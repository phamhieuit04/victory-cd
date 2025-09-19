<script setup lang="ts">
import AppToggleTheme from './AppToggleTheme.vue';
import { Separator } from '../ui/separator';
import { SidebarTrigger } from '../ui/sidebar';

</script>

<template>
    <header class="flex items-center justify-between mb-2.5 shrink">
        <div class="flex items-center gap-2 ">
            <SidebarTrigger class="cursor-pointer" />
            <h1 class="font-bold">{{ $route.name }}</h1>
        </div>
        <AppToggleTheme />
    </header>
</template>