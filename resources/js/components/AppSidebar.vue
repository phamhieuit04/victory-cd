<script setup>
import { Sidebar, SidebarContent, SidebarGroup, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from './ui/sidebar';
import { routes } from '@/router';
</script>

<template>
    <Sidebar collapsible="icon">
        <SidebarContent class="p-0.5">
            <SidebarGroup>
                <SidebarMenu>
                    <SidebarMenuItem v-for="route in routes" :key="route.id">
                        <SidebarMenuButton asChild>
                            <RouterLink :to="route.path" active-class="underline font-semibold">
                                <component :is="route.icon" :size="100" />
                                <span>{{ route.name }}</span>
                            </RouterLink>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarGroup>
        </SidebarContent>
    </Sidebar>
</template>