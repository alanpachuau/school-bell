<template>
    <el-tabs v-model="activeName" :tab-position="tabPosition" @tab-click="handleTabClick" style="height: 90vh;overflow:auto;">
        <el-tab-pane name="first">
            <span slot="label">Bell <i class="el-icon-time"></i></span>
            <div style="margin-left: 50px;">
                <el-row :gutter="20" v-if="bells.length">
                    <el-col :span="20">
                        <h3>Bells</h3>

                        <el-collapse>
                            <el-collapse-item v-for="bell in bells" :gutter="20" :key="bell.id" :title="bell.name" :name="bell.id">
                                <el-row type="flex" :gutter=10>
                                    <el-col :span="10">
                                        <el-tag size="mini" type="info" v-if="bell.sound1_id">{{bell.sound1_title}}</el-tag>
                                        <el-tag size="mini" type="warning" v-if="bell.sound1_id"><i class="el-icon-time"></i> {{bell.sound1_volume}}%</el-tag>
                                    </el-col>
                                    <el-col :span="10">
                                        <el-tag size="mini" type="info" v-if="bell.sound2_id">{{bell.sound2_title}}</el-tag>
                                        <el-tag size="mini" type="warning" v-if="bell.sound2_id"><i class="el-icon-time"></i> {{bell.sound2_volume}}%</el-tag>
                                    </el-col>
                                    <el-col :span="4" style="text-align:right;">
                                        <el-button type="success" @click="editBell(bell)" size="mini" round icon="el-icon-edit"></el-button>
                                        <el-button type="danger" @click="removeBell(bell.id)" size="mini" round icon="el-icon-close"></el-button>
                                    </el-col>
                                </el-row>
                                <el-row type="flex" :gutter=10>
                                    <el-col :span="14">
                                        <el-tag size="mini" v-if="bell.sunday">Sunday</el-tag>
                                        <el-tag size="mini" v-if="bell.monday">Monday</el-tag>
                                        <el-tag size="mini" v-if="bell.tuesday">Tuesday</el-tag>
                                        <el-tag size="mini" v-if="bell.wednesday">Wednesday</el-tag>
                                        <el-tag size="mini" v-if="bell.thursday">Thursday</el-tag>
                                        <el-tag size="mini" v-if="bell.friday">Friday</el-tag>
                                        <el-tag size="mini" v-if="bell.saturday">Saturday</el-tag>
                                        <el-tag size="mini" type="warning"><i class="el-icon-bell"></i> {{bell.time}}</el-tag>
                                    </el-col>
                                    <el-col :span="10">
                                        <el-tag size="mini" type="success" v-if="bell.sw1">SW1</el-tag>
                                        <el-tag size="mini" type="success" v-if="bell.sw2">SW2</el-tag>
                                        <el-tag size="mini" type="success" v-if="bell.sw3">SW3</el-tag>
                                        <el-tag size="mini" type="success" v-if="bell.sw4">SW4</el-tag>
                                        <el-tag size="mini" type="warning"><i class="el-icon-time"></i> {{bell.switch_on}}</el-tag>
                                    </el-col>
                                </el-row>
                            </el-collapse-item>
                        </el-collapse>
                    </el-col>
                    <el-col :span="4">
                        <p style="text-align: center;margin-bottom: 30px;">
                            <el-button @click="createFormVisible = true" size="huge" round><i class="el-icon-plus"></i>
                                Add Bell
                            </el-button>
                        </p>
                    </el-col>
                </el-row>
                <div class="no-schedule" v-else>
                    <h3>Okay! I believe this is the first time you've come here.</h3>
                    <p>No bell schedule available at the moment! You can create new schedule now by clicking the button
                        below.</p>
                    <p>
                        <el-button @click="createFormVisible = true" size="huge" round><i class="el-icon-plus"></i>
                            Create
                            Schedule
                        </el-button>
                    </p>
                </div>

                <el-dialog title="New Bell" width="80%" :visible.sync="createFormVisible">
                    <el-form ref="newBell" :rules="rules" :model="createForm" label-width="120px" label-position="left">
                        <el-row :gutter="60">
                            <el-col :span="12">
                                <el-form-item prop="name" label="Name">
                                    <el-input v-model="createForm.name" placeholder="Enter name to identify this bell"
                                              auto-complete="off"></el-input>
                                </el-form-item>
                                <el-form-item prop="days" label="Day">
                                    <el-select style="width: 100%"
                                               v-model="createForm.days"
                                               clearable
                                               multiple
                                               placeholder="Choose day">
                                        <el-option
                                                v-for="item in days"
                                                :key="item.id"
                                                :label="item.name"
                                                :value="item.id">
                                        </el-option>
                                    </el-select>
                                </el-form-item>
                                <el-form-item prop="time" label="Time">
                                    <el-time-picker
                                            format="HH:mm"
                                            value-format="HH:mm"
                                            type="fixed-time"
                                            placeholder="Pick a time"
                                            v-model="createForm.time"
                                            style="width: 100%;"></el-time-picker>
                                </el-form-item>

                                <el-form-item prop="sound1" label="Sound One">
                                    <el-select style="width: 100%"
                                               v-model="createForm.sound1"
                                               clearable
                                               placeholder="Choose sound one">
                                        <el-option
                                                v-for="item in sounds"
                                                :key="item.id"
                                                :label="item.name"
                                                :value="item.id">
                                        </el-option>
                                    </el-select>
                                    <div class="block">
                                        <span class="demonstration">Sound Volume</span>
                                        <el-slider style="float: right; width: 70%; line-height: 34px;"
                                                   v-model="createForm.sound1Volume">
                                        </el-slider>
                                    </div>
                                </el-form-item>
                                <el-form-item prop="sound2" label="Sound Two">
                                    <el-select style="width: 100%"
                                               v-model="createForm.sound2"
                                               clearable
                                               placeholder="Choose sound two">
                                        <el-option
                                                v-for="item in sounds"
                                                :key="item.id"
                                                :label="item.name"
                                                :value="item.id">
                                        </el-option>
                                    </el-select>
                                    <div class="block">
                                        <span class="demonstration">Sound Volume</span>
                                        <el-slider style="float: right; width: 70%; line-height: 34px;"
                                                   v-model="createForm.sound2Volume">
                                        </el-slider>
                                    </div>
                                </el-form-item>
                            </el-col>
                            <el-col :span="12">
                                <el-form-item prop="switches" label="Switches">
                                    <el-switch style="margin-right: 10px;" v-model="createForm.switch1"
                                               active-text="SW1"></el-switch>
                                    <el-switch style="margin-right: 10px;" v-model="createForm.switch2"
                                               active-text="SW2"></el-switch>
                                    <el-switch style="margin-right: 10px;" v-model="createForm.switch3"
                                               active-text="SW3"></el-switch>
                                    <el-switch style="margin-right: 10px;" v-model="createForm.switch4"
                                               active-text="SW4"></el-switch>
                                    <div class="sub-title">Only active switches will be controlled</div>
                                </el-form-item>
                                <el-form-item prop="switchOn" label="Switch On At">
                                    <el-time-picker
                                            format="HH:mm"
                                            value-format="HH:mm"
                                            type="fixed-time"
                                            placeholder="Pick a time"
                                            v-model="createForm.switchOn"
                                            style="width: 100%;"></el-time-picker>
                                    <div class="sub-title">Switches will be turned off automatically</div>
                                </el-form-item>
                            </el-col>
                        </el-row>
                    </el-form>
                    <span slot="footer" class="dialog-footer">
                        <el-button @click="createFormVisible = false" round>Close</el-button>
                        <el-button @click="save('newBell')" round>Save</el-button>
                    </span>
                </el-dialog>

                <el-dialog title="Edit Bell" width="80%" :visible.sync="editFormVisible">
                    <el-form ref="editBell" :rules="rules" :model="editForm" label-width="120px" label-position="left">
                        <el-row :gutter="60">
                            <el-col :span="12">
                                <el-form-item prop="name" label="Name">
                                    <el-input v-model="editForm.name" placeholder="Enter name to identify this bell"
                                              auto-complete="off"></el-input>
                                </el-form-item>
                                <el-form-item prop="days" label="Day">
                                    <el-select style="width: 100%"
                                               v-model="editForm.days"
                                               clearable
                                               multiple
                                               placeholder="Choose day">
                                        <el-option
                                                v-for="item in days"
                                                :key="item.id"
                                                :label="item.name"
                                                :value="item.id">
                                        </el-option>
                                    </el-select>
                                </el-form-item>
                                <el-form-item prop="time" label="Time">
                                    <el-time-picker
                                            format="HH:mm"
                                            value-format="HH:mm"
                                            type="fixed-time"
                                            placeholder="Pick a time"
                                            v-model="editForm.time"
                                            style="width: 100%;"></el-time-picker>
                                </el-form-item>

                                <el-form-item prop="sound1" label="Sound One">
                                    <el-select style="width: 100%"
                                               v-model="editForm.sound1"
                                               clearable
                                               placeholder="Choose sound one">
                                        <el-option
                                                v-for="item in sounds"
                                                :key="item.id"
                                                :label="item.name"
                                                :value="item.id">
                                        </el-option>
                                    </el-select>
                                    <div class="block">
                                        <span class="demonstration">Sound Volume</span>
                                        <el-slider style="float: right; width: 70%; line-height: 34px;"
                                                   v-model="editForm.sound1Volume">
                                        </el-slider>
                                    </div>
                                </el-form-item>
                                <el-form-item prop="sound2" label="Sound Two">
                                    <el-select style="width: 100%"
                                               v-model="editForm.sound2"
                                               clearable
                                               placeholder="Choose sound two">
                                        <el-option
                                                v-for="item in sounds"
                                                :key="item.id"
                                                :label="item.name"
                                                :value="item.id">
                                        </el-option>
                                    </el-select>
                                    <div class="block">
                                        <span class="demonstration">Sound Volume</span>
                                        <el-slider style="float: right; width: 70%; line-height: 34px;"
                                                   v-model="editForm.sound2Volume">
                                        </el-slider>
                                    </div>
                                </el-form-item>
                            </el-col>
                            <el-col :span="12">
                                <el-form-item prop="switches" label="Switches">
                                    <el-switch style="margin-right: 10px;" v-model="editForm.switch1"
                                               active-text="SW1"></el-switch>
                                    <el-switch style="margin-right: 10px;" v-model="editForm.switch2"
                                               active-text="SW2"></el-switch>
                                    <el-switch style="margin-right: 10px;" v-model="editForm.switch3"
                                               active-text="SW3"></el-switch>
                                    <el-switch style="margin-right: 10px;" v-model="editForm.switch4"
                                               active-text="SW4"></el-switch>
                                    <div class="sub-title">Only active switches will be controlled</div>
                                </el-form-item>
                                <el-form-item prop="switchOn" label="Switch On At">
                                    <el-time-picker
                                            format="HH:mm"
                                            value-format="HH:mm"
                                            type="fixed-time"
                                            placeholder="Pick a time"
                                            v-model="editForm.switchOn"
                                            style="width: 100%;"></el-time-picker>
                                    <div class="sub-title">Switches will be turned off automatically</div>
                                </el-form-item>
                            </el-col>
                        </el-row>
                    </el-form>
                    <span slot="footer" class="dialog-footer">
                        <el-button @click="editFormVisible = false" round>Close</el-button>
                        <el-button @click="updateBell(editForm)" round>Save</el-button>
                    </span>
                </el-dialog>
            </div>
        </el-tab-pane>
        <el-tab-pane name="second">
            <span slot="label">Sound <i class="el-icon-service"></i></span>
            <div style="margin-left: 50px;">
                <el-row :gutter="20">
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
                                :file-list="sounds"
                                accept=".mp3"
                                action="/sounds/upload">
                            <el-button slot="trigger" size="large" round><i class="el-icon-upload2"></i> Add Sound</el-button>
                        </el-upload>
                    </el-col>
                </el-row>
            </div>
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
                uploadHeaders: {
                    'X-CSRF-TOKEN': window.Laravel.csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                bells: [],
                createFormVisible: false,
                sounds: [],
                days: [
                    {id: 'sunday', name: 'Sunday'},
                    {id: 'monday', name: 'Monday'},
                    {id: 'tuesday', name: 'Tuesday'},
                    {id: 'wednesday', name: 'Wednesday'},
                    {id: 'thursday', name: 'Thursday'},
                    {id: 'friday', name: 'Friday'},
                    {id: 'saturday', name: 'Saturday'},
                ],
                createForm: {},
                rules: {
                    name: [
                        {required: true, message: 'Please input name for this bell', trigger: 'blur'},
                    ],
                    days: [
                        {required: true, message: 'Please select day(s)', trigger: 'change'}
                    ],
                    time: [
                        {required: true, message: 'Please select time for the bell', trigger: 'change'}
                    ],
                    sound1: [
                        {required: true, message: 'Please choose bell sound', trigger: 'change'}
                    ]
                },
                editFormVisible: false,
                editForm: {},
            };
        },
        created: function () {
            this.initFormData()
            this.fetchBells()
            this.fetchSounds()
        },
        methods: {
            handleTabClick(tab, event) {
                // eslint-disable-next-line no-console
                if (tab.name == 'third') {
                    $("#logout-form").submit();
                }
            },

            handleSuccess(response, file, fileList) {
                this.fetchSounds()
                this.$message('New sound added');
            },
            handleRemove(file, fileList) {
                axios.delete('/sounds/' + file.id, {
                }).then(response => {
                    this.$message('Sound removed');
                    this.fetchSounds()
                })
            },
            handlePreview(file) {
                console.log(file);
            },
            handleExceed(files, fileList) {
                this.$message.warning(`The limit is 3, you selected ${files.length} files this time, add up to ${files.length + fileList.length} totally`);
            },
            fetchSounds() {
                axios.get('/sounds', {}).then(response => {
                    this.sounds = response.data
                })
            },

            fetchBells() {
                axios.get('/bells', {}).then(response => {
                    this.bells = response.data
                })
            },
            validate() {

            },
            save(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        axios.post('/bells', this.createForm)
                            .then(response => {
                                this.$message('New bell scheduled!');
                                this.createFormVisible = false
                                this.$refs[formName].resetFields();
                                this.initFormData()
                                this.fetchBells()
                            })
                            .catch(error => {
                                if (error && typeof error.response.data === "object") {
                                    console.log(_.flatten(_.toArray(error.response.data)))
                                } else {
                                    console.log(['Something went wrong. Please try again.'])
                                }
                            });
                    } else {
                        return false;
                    }
                });
            },
            initFormData() {
                this.createForm = {
                    name: '',
                    sound1: '',
                    sound2: '',
                    days: [],
                    time: '',
                    sound1Volume: 90,
                    sound2Volume: 90,
                    switch1: false,
                    switch2: false,
                    switch3: false,
                    switch4: false,
                    switchOn: '',
                }
            },
            removeBell(bellId) {
                axios.delete('/bells/' + bellId, {
                }).then(response => {
                    this.$message('Bell removed');
                    this.fetchBells()
                })
            },
            editBell(bell) {
              let days = [];
              if(bell.sunday == 1) {
                days.push('sunday');
              }
              if(bell.monday == 1) {
                days.push('monday');
              }
              if(bell.tuesday == 1) {
                days.push('tuesday');
              }
              if(bell.wednesday == 1) {
                days.push('wednesday');
              }
              if(bell.thursday == 1) {
                days.push('thursday');
              }
              if(bell.friday == 1) {
                days.push('friday');
              }
              if(bell.saturday == 1) {
                days.push('saturday');
              }

                this.editForm = {
                    id: bell.id,
                    name: bell.name,
                    sound1: bell.sound1_id,
                    sound2: bell.sound2_id,
                    days: days,
                    time: bell.time,
                    sound1Volume: bell.sound1_volume,
                    sound2Volume: bell.sound2_volume,
                    switch1: bell.sw1 == 1,
                    switch2: bell.sw2 == 1,
                    switch3: bell.sw3 == 1,
                    switch4: bell.sw4 == 1,
                    switchOn: bell.switch_on,
                }

                this.editFormVisible = true;
            },
            updateBell(bell) {
                this.$refs['editBell'].validate((valid) => {
                    if (valid) {
                        axios.put('/bells/' + bell.id, this.editForm)
                            .then(response => {
                                this.$message('Bell updated!');
                                this.editFormVisible = false
                                this.$refs['editBell'].resetFields();
                                this.initFormData()
                                this.fetchBells()
                            })
                            .catch(error => {
                                if (error && typeof error.response.data === "object") {
                                    console.log(_.flatten(_.toArray(error.response.data)))
                                } else {
                                    console.log(['Something went wrong. Please try again.'])
                                }
                            });
                    } else {
                        return false;
                    }
                });
            },
        }
    };
</script>

<style>
    @import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro');
    @import url('/css/material-icons.css');

    body {
        font-family: 'Source Sans Pro', sans-serif;
    }

    .no-schedule {
        text-align: center;
        font-size: 18px;
        color: #969696;
        padding: 10px 0px 0 30px;
    }

    .no-schedule h3 {
        margin-bottom: 10px;
    }

    .no-schedule p {
        margin-bottom: 30px;
    }
</style>
