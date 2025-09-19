<script setup>
import AppHeader from '@/components/AppHeader.vue';
import AppSidebar from '@/components/AppSidebar.vue';
import { Separator } from '@/components/ui/separator';
import { SidebarInset, SidebarProvider } from '@/components/ui/sidebar';
</script>

<template>
    <SidebarProvider style="--sidebar-width: 18rem;">
        <AppSidebar />
        <SidebarInset class="p-4">
            <AppHeader />
            <slot />
        </SidebarInset>
    </SidebarProvider>
</template>