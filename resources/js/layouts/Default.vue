<script setup>
import AppSidebar from '@/components/AppSidebar.vue';
import AppToggleTheme from '@/components/AppToggleTheme.vue';
import { SidebarProvider, SidebarTrigger } from '@/components/ui/sidebar';
</script>

<template>
    <SidebarProvider style="--sidebar-width: 20rem;">
        <AppSidebar />
        <main class="p-2.5 container mx-auto">
            <div class="flex justify-between mb-2.5">
                <SidebarTrigger />
                <AppToggleTheme />
            </div>
            <slot />
        </main>
    </SidebarProvider>
</template>