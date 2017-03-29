<template>
    <a @click="toggleDropdown">
        <slot></slot>
    </a>
</template>

<script>
    import dropdownMixin from './mixins/DropdownMixin';
    export default {
        mixins: [dropdownMixin],
    }

</script>
