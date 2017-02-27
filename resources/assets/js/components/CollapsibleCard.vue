<template>
    <div class="card collapsible" :class="{'is-active': isActive}">
        <header class="card-header">
            <slot name="header"></slot>
        </header>
        <div class="card-toggle" @click="toggleCollapsible">
            <i class='fa fa-fw' :class="isActive ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
        </div>
        <!--<transition enter-active-class="animated fadeInDown" leave-active-class="animated fadeOutUp">-->
            <div v-show="isActive" class="card-content" @click="toggleCollapsible">
                <slot></slot>
            </div>
            <slot name="footer"></slot>
        <!--</transition>-->
    </div>
</template>
<script>
    export default{
        props: {
            active: {
                type: Boolean,
                default: false,
            }
        },
    
        data() {
            return {
                isActive: this.active
            }
        },
        
        methods: {
            toggleCollapsible: function() {
                this.isActive = !this.isActive;
            }
        }
    }
</script>
