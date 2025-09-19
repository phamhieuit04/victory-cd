<script setup>
import { PanelLeft } from "lucide-vue-next";
import { cn } from "@/lib/utils";
import { Button } from '@/components/ui/button';
import { useSidebar } from "./utils";

const props = defineProps({
    class: { type: null, required: false },
});

const { toggleSidebar } = useSidebar();
</script>

<template>
    <Button class="cursor-pointer" data-sidebar="trigger" data-slot="sidebar-trigger" variant="ghost" size="icon"
        :class="cn('size-8', props.class)" @click="toggleSidebar">
        <PanelLeft />
        <span class="sr-only">Toggle Sidebar</span>
    </Button>
</template>
