<template>
    <div class="treeMenu">
        <div class="dd" id="nestable">
            <ol class="dd-list">
                <node-tree v-for="(node, key) in treeData" :node="node" :key="node.id"></node-tree>
            </ol>
        </div>

        <transition name="fade">
            <div v-if="showAlert" ref="alertMessage" role="alert" :class="`my-2 alert ` + alertType">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{message}}
            </div>
        </transition>
        <div class="pt-2 text-right">
            <button :disabled="loading" @click="updateMenu" class="btn btn-default">
             <span v-if="loading" role="status" aria-hidden="true"
                   class="spinner-border spinner-border-sm"></span>
                Сохранить изменения
                <i class="fa fa-save"></i>
            </button>
        </div>
    </div>
</template>

<script>
    import NodeTree from "./NodeTree"

    export default {
        components: {
            NodeTree
        },
        props: {
            treeData: Object,
            routeUpdate: '',

        },
        data() {
            return {
                changeTree: Object,
                loading: false,
                message: '',
                alertType: '',
                showAlert: false
            }
        },
        mounted() {
            var $vm = this;
            $(document).ready(function () {
                $('#nestable').nestable({
                    group: 1,
                    callback: function (e) {
                        var list = e.length ? e : $(e.target);
                        $vm.changeTree = JSON.stringify(list.nestable('toArray'));
                    }
                }); //.on('change', updateOutput)
            });
            console.log('Component mounted.')
        },

        methods: {
            updateMenu() {
                var $vm = this;
                this.loading = true;
                axios.post(this.routeUpdate, {'jsonString': this.changeTree})
                    .then(function (response) {
                        $vm.showAlert = true;
                        $vm.alertType = 'alert-success';
                        $vm.message = 'Меню успешно обновленно';
                    })
                    .catch(function (error) {
                        console.log(error.response);
                        console.log(error.response.data.message);
                        $vm.showAlert = true;
                        $vm.alertType = 'alert-danger';
                        $vm.message = error.response.statusText;
                    })
                    .finally(() => {
                        setTimeout(function () {
                            $vm.showAlert = false;
                        }, 2000);
                        this.loading = false
                    });
            }
        },
    }
</script>

<style scoped>

</style>