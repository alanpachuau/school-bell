<template>
    <div>
        <el-row :gutter="20" v-if="bells.length">
            <el-col :span="20">
                <el-collapse v-model="activeNames">
                    <el-collapse-item title="Consistency" name="1">
                        <div>A with real life: in line with the process and logic of real life, and comply with
                            languages and habits that the users are used to;
                        </div>
                        <div>Consistent within interface: all elements should be consistent, such as: design style,
                            icons and texts, position of elements, etc.
                        </div>
                    </el-collapse-item>
                    <el-collapse-item title="Feedback" name="2">
                        <div>Operation feedback: enable the users to clearly perceive their operations by style updates
                            and interactive effects;
                        </div>
                        <div>Visual feedback: reflect current state by updating or rearranging elements of the page.
                        </div>
                    </el-collapse-item>
                    <el-collapse-item title="Efficiency" name="3">
                        <div>Simplify the process: keep operating process simple and intuitive;</div>
                        <div>Definite and clear: enunciate your intentions clearly so that the users can quickly
                            understand and make decisions;
                        </div>
                        <div>Easy to identify: the interface should be straightforward, which helps the users to
                            identify and frees them from memorizing and recalling.
                        </div>
                    </el-collapse-item>
                    <el-collapse-item title="Controllability" name="4">
                        <div>Decision making: giving advices about operations is acceptable, but do not make decisions
                            for the users;
                        </div>
                        <div>Controlled consequences: users should be granted the freedom to operate, including
                            canceling, aborting or terminating current operation.
                        </div>
                    </el-collapse-item>
                </el-collapse>
            </el-col>
            <el-col :span="4">
                <p style="text-align: center;margin-bottom: 30px;">
                    <el-button @click="createFormVisible = true" size="huge" round><i class="el-icon-plus"></i> Add Bell</el-button>
                </p>
            </el-col>
        </el-row>
        <div class="no-schedule" v-else>
            <h3>Okay! I believe this is the first time you've come here.</h3>
            <p>No bell schedule available at the moment! You can create new schedule now by clicking the button
                below.</p>
            <p>
                <el-button @click="createFormVisible = true" size="huge" round><i class="el-icon-plus"></i> Create
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
                                        :value="item.url">
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
                                        :value="item.url">
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
                            <el-switch style="margin-right: 10px;" v-model="createForm.switch1" active-text="SW1"></el-switch>
                            <el-switch style="margin-right: 10px;" v-model="createForm.switch2" active-text="SW2"></el-switch>
                            <el-switch style="margin-right: 10px;" v-model="createForm.switch3" active-text="SW3"></el-switch>
                            <el-switch style="margin-right: 10px;" v-model="createForm.switch4" active-text="SW4"></el-switch>
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
    </div>
</template>
<script>
    export default {
        name: 'bell-schedule',
        data() {
            return {
                activeNames: ['1'],
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
                        { required: true, message: 'Please input name for this bell', trigger: 'blur' },
                    ],
                    days: [
                        { required: true, message: 'Please select day(s)', trigger: 'change' }
                    ],
                    time: [
                        { required: true, message: 'Please select time for the bell', trigger: 'change' }
                    ],
                    sound1: [
                        { required: true, message: 'Please choose bell sound', trigger: 'change' }
                    ]
                }
            };
        },
        watch: {
        },
        created: function() {
            this.clearFormData()
            this.fetchBells()
            this.fetchSounds()
        },
        methods: {
            fetchSounds() {
                axios.get('/sounds', {
                }).then(response => {
                    this.sounds = response.data
                })
            },
            fetchBells() {
                axios.get('/bells', {
                }).then(response => {
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
                                this.clearFormData()
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
            clearFormData() {
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
            }
        },
    };
</script>

<style type="text/css">
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