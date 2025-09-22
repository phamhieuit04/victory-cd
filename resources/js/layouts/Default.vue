<script setup>
import AppHeader from '@/components/partials/AppHeader.vue';
import AppLoading from '@/components/partials/AppLoading.vue';
import AppSidebar from '@/components/partials/AppSidebar.vue';
import { SidebarInset, SidebarProvider } from '@/components/ui/sidebar';
</script>

<template>
    <SidebarProvider style="--sidebar-width: 18rem;">
        <AppSidebar />
        <SidebarInset class="p-4">
            <AppHeader />
            <slot />
            <AppLoading />
        </SidebarInset>
    </SidebarProvider>
</template>