<template>
    <div>
        <el-row :gutter="100">
            <el-col :span="12">
                <h3>Sounds</h3>
                <el-upload
                        :with-credentials="true"
                        :on-success="handleSuccess"
                        :on-remove="handleRemove"
                        :headers="uploadHeaders"
                        class="upload-demo"
                        :show-file-list="true"
                        ref="upload"
                        :file-list="fileList"
                        accept=".mp3"
                        action="/sounds/upload">
                    <el-button slot="trigger" size="large" round><i class="el-icon-upload2"></i> Add Sound</el-button>
                </el-upload>
            </el-col>
        </el-row>
    </div>
</template>
<script>
    export default {
        name: 'bell-sound',
        data() {
            return {
                activeNames: ['1'],
                sounds: [],
                createFormVisible: false,
                createForm: {
                    name: '',
                    sound: '',
                },
                uploadHeaders: {
                    'X-CSRF-TOKEN': window.Laravel.csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                fileList: [{
                    id: 1,
                    name: 'food.jpeg',
                    url: 'https://fuss10.elemecdn.com/3/63/4e7f3a15429bfda99bce42a18cdd1jpeg.jpeg?imageMogr2/thumbnail/360x360/format/webp/quality/100',
                }, {
                    id: 2,
                    name: 'food2.jpeg',
                    url: 'https://fuss10.elemecdn.com/3/63/4e7f3a15429bfda99bce42a18cdd1jpeg.jpeg?imageMogr2/thumbnail/360x360/format/webp/quality/100',
                }],
            };
        },
        created: function () {
            this.fetchSounds()
        },
        methods: {
            fetchSounds() {
                let self = this
                axios.get('/sounds', {
                }).then(response => {
                    this.fileList = response.data
                })
            },
            handleSuccess(response, file, fileList) {
                this.fetchSounds()
            },
            handleRemove(file, fileList) {
                axios.delete('/sounds/' + file.id, {
                }).then(response => {
                })
            },
            handlePreview(file) {
                console.log(file);
            },
            handleExceed(files, fileList) {
                this.$message.warning(`The limit is 3, you selected ${files.length} files this time, add up to ${files.length + fileList.length} totally`);
            },
        },
    };
</script>

<style type="text/css">
    .no-sound {
        text-align: center;
        font-size: 18px;
        color: #969696;
        padding: 10px 0px 0 30px;
    }

    .no-sound h3 {
        margin-bottom: 10px;
    }

    .no-sound p {
        margin-bottom: 30px;
    }
</style>