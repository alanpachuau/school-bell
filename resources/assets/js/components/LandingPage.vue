<template>
    <el-tabs v-model="activeName" :tab-position="tabPosition" @tab-click="handleClick" style="height: 80vh;">
        <el-tab-pane name="first">
            <span slot="label">Bell <i class="el-icon-time"></i></span>
            <bell-schedule></bell-schedule>
        </el-tab-pane>
        <el-tab-pane name="second">
            <span slot="label">Sound <i class="el-icon-service"></i></span>
            <bell-sound></bell-sound>
        </el-tab-pane>
        <el-tab-pane name="third">
            <span slot="label">Logout <i class="el-icon-arrow-right"></i></span>
            <p>Logging out... <i class="el-icon-loading"></i></p>
        </el-tab-pane>
    </el-tabs>
</template>

<script>
    export default {
        name: 'landing-page',
        data() {
            return {
                activeName: 'first',
                tabPosition: 'left',
            };
        },
        methods: {
            handleClick(tab, event) {
                // eslint-disable-next-line no-console
                if (tab.name == 'third') {
                    $("#logout-form").submit();
                }
            }
        }
    };
</script>

<style>
    @import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro');
    @import url('/css/material-icons.css');

    body { font-family: 'Source Sans Pro', sans-serif; }
</style>
