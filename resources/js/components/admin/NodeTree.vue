<template>
    <li class="dd-item" :data-id="node.id">
        <div class="dd-handle">
            <span class="drag-indicator"></span>

            <div class="title">{{node.title}}</div>

            <form :action="node.destroy_path" class="dd-nodrag btn-group ml-auto" method="POST">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" :value="token.content">
                <!-- edit menu item  -->
                <a :href="node.edit_path" class="btn btn-sm btn-default edit" title="Редактировать"
                   data-toggle="tooltip">
                    <i class="fa fa-edit"></i>
                </a>
                <!-- delete menu item -->
                <button type="submit" class="btn btn-sm btn-default delete" data-toggle="tooltip" title="Удалить">
                    <i class="fa fa-trash"></i>
                </button>

            </form>

        </div>
        <ol v-if="node.children" class="dd-list">
            <node-tree v-for="child in node.children" :node="child" :key="child.id"></node-tree>
        </ol>
    </li>
</template>

<script>
    export default {
        name: "NodeTree",
        props: {
            node: Object,

        },
        data() {
            return {
                token: '',
            }

        },

        mounted() {
            this.token = document.head.querySelector('meta[name="csrf-token"]');
            console.log('Component mounted.')
        },

        methods: {
            updateTree() {

            }
        }
    }
</script>

<style scoped>

</style>