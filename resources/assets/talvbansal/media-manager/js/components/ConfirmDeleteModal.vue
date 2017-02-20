<template>
    <media-modal @close="close()" :size="size" :show="show" v-if="show">
        <div>
            <div class="modal-header">
                <h4 class="modal-title">Delete item</h4>
                <button class="close" type="button" @click="close()">×</button>
            </div>

            <div v-if="loading" class="text-center">
                <span class="spinner icon-spinner2"></span>Loading...
            </div>

            <div v-else>
                <div class="modal-body">
                    <div class="form-group m-t-30">
                        <label>Are you sure you want to delete the following item?</label>
                        <p class="form-control m-none">{{ this.getItemName(this.currentFile) }}</p>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-default" type="button" @click="close">
                        Cancel
                    </button>
                    <button class="btn btn-error" @click="deleteItem()">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </media-modal>
</template>

<script>
    export default{
        props: {
            currentPath: {},
            currentFile: {},
            show: {
                default: false
            }
        },

        data: function () {
            return {
                loading: false,
                newItemName: null,
                size: 'modal-md'
            }
        },

        mounted() {
            document.addEventListener("keydown", function (e) {
                if (this.show && e.keyCode == 13) {
                    this.deleteItem();
                }
            });
        },

        methods: {
            close: function () {
                this.newItemName = null;
                this.loading = false;
                this.$emit('close');
            },

            deleteItem: function () {

                if (this.isFolder(this.currentFile)) {
                    return this.deleteFolder();
                }
                return this.deleteFile();
            },

            deleteFile: function () {
                if (this.currentFile) {
                    var data = {
                        'path': this.currentFile.fullPath
                    };
                    this.delete('/admin/browser/delete', data);
                }
            },

            deleteFolder: function () {
                if (this.isFolder(this.currentFile)) {
                    var data = {
                        'folder': this.currentPath,
                        'del_folder': this.currentFile
                    };
                    this.delete('/admin/browser/folder', data);
                }
            },

            delete: function (route, payload) {
                this.loading = true;
                this.$http.delete(route, {body: payload}).then(
                    function (response) {
                        window.eventHub.$emit('media-manager-reload-folder');
                        this.mediaManagerNotify(response.data.success);
                        this.close();
                    },
                    function (response) {
                        var error = (response.data.error) ? response.data.error : response.statusText;
                        this.mediaManagerNotify(error, 'danger');
                        this.close();
                    }
                );
            }
        }

    }
</script>