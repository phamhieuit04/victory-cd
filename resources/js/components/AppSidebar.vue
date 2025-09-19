<script setup>
import { Sidebar, SidebarContent, SidebarGroup, SidebarGroupContent, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from './ui/sidebar';
import { routes } from '@/router';
</script>

<template>
    <Sidebar collapsible="icon">
        <SidebarContent class="pt-2.5">
            <SidebarGroup>
                <SidebarGroupContent>
                    <SidebarMenu>
                        <SidebarMenuItem v-for="route in routes" :key="route.id">
                            <SidebarMenuButton as-child :is-active="route.path == $route.path">
                                <RouterLink :to="route.path">
                                    <component :is="route.icon" />
                                    <span>{{ route.name }}</span>
                                </RouterLink>
                            </SidebarMenuButton>
                        </SidebarMenuItem>
                    </SidebarMenu>
                </SidebarGroupContent>
            </SidebarGroup>
        </SidebarContent>
    </Sidebar>
</template>