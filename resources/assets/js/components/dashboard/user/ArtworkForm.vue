<template>
    <div class="app-artwork-form">
        <el-form label-position="top" :model="artwork" ref="artwork" :rules="rules" v-if="artwork"
                 class="artwork">
            <el-card style="margin-bottom: 20px;">
                <div slot="header" class="artwork-header">
                    <span>Photos</span>
                    <a v-if="artwork_" :href="'/artwork/' + artwork.id" target="_blank"
                       class="el-button el-button--default el-button--mini">Preview</a>
                </div>

                <el-form-item label="Upload primary photo of your artwork." required prop="image">

                    <el-upload
                            class="artwork-image"
                            list-type="picture-card"
                            :file-list="artwork.image"
                            action="/api/artwork/upload-artwork-image/"
                            :headers="{'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN' : csrf}"
                            accept=".jpg, .jpeg"
                            :on-preview="handlePictureCardPreview"
                            :on-remove="handleRemoveImage"
                            :on-success="handleImageSuccess"
                            :before-upload="beforeImageUpload">
                        <!--<img v-if="artwork.image.url" :src="'/imagecache/height-200/' + artwork.image.url">-->
                        <div class="artwork-image-label">
                            <i class="el-icon-picture"></i>
                            <div>Primary image</div>
                        </div>
                    </el-upload>

                    <el-dialog :visible.sync="dialogVisible">
                        <img width="100%" :src="dialogImageUrl" alt="">
                    </el-dialog>

                </el-form-item>

                <el-form-item label="Add as many images as you can so buyers can see every detail.">

                    <el-upload
                            multiple
                            class="artwork-image"
                            action="/api/artwork/upload-artwork-images/"
                            :file-list="artwork.images"
                            :headers="{'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN' : csrf}"
                            :on-preview="handlePictureCardPreview"
                            :on-remove="handleRemoveImages"
                            :on-success="handleImagesSuccess"
                            list-type="picture-card"
                            accept=".jpg, .jpeg">
                        <div class="artwork-image-label">
                            <i class="el-icon-picture-outline"></i>
                            <div>Other images</div>
                        </div>
                    </el-upload>

                </el-form-item>

            </el-card>

            <el-card style="margin-bottom: 20px;">
                <div slot="header">Artwork Details</div>

                <el-form-item label="Artwork Name (Title)" prop="name">
                    <el-input placeholder="Please input" v-model="artwork.name"></el-input>
                </el-form-item>

                <el-row :gutter="20">

                    <el-col :sm="8" v-if="user.seller_type === 'gallery'">
                        <el-form-item label="Who made it?" prop="made_by" required>
                            <el-input v-model="artwork.made_by"></el-input>
                        </el-form-item>
                    </el-col>

                    <el-col :sm="8">
                        <el-form-item label="What is it?" prop="category" required>
                            <el-select value="" v-model="artwork.category" placeholder="Select Category">
                                <el-option v-for="(label, value) in trans('artwork-category')" :key="value"
                                           :value="value"
                                           :label="label"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>

                    <el-col :sm="8">
                        <el-form-item label="When was it made?" required prop="date_of_completion">
                            <el-date-picker
                                    v-model="artwork.date_of_completion"
                                    type="year"
                                    value-format="yyyy-MM-dd HH:mm:ss"
                                    placeholder="Pick a year">
                            </el-date-picker>
                        </el-form-item>
                    </el-col>

                </el-row>

                <el-form-item label="Artwork Description" required prop="description">
                    <el-input type="textarea" placeholder="Please input" v-model="artwork.description"></el-input>
                </el-form-item>

                <el-form-item>
                    <span slot="label">Inspiration</span>
                    <el-input type="textarea" placeholder="Please input" v-model="artwork.inspiration"></el-input>
                </el-form-item>

                <el-row :gutter="20">
                    <el-col :sm="8">
                        <el-form-item label="What medium (materials) were used?">
                            <el-select value="" v-model="artwork.medium" multiple filterable allow-create collapse-tags
                                       default-first-option placeholder="Select materials">
                                <el-option v-for="medium in options('medium')" :key="medium.value" :label="medium.label"
                                           :value="medium.value"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :sm="8">
                        <el-form-item label="Art direction">
                            <el-select value="" v-model="artwork.direction" multiple filterable allow-create
                                       collapse-tags
                                       default-first-option placeholder="Select">
                                <el-option v-for="direction in options('direction')" :key="direction.value"
                                           :label="direction.label"
                                           :value="direction.value"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :sm="8">
                        <el-form-item label="Theme">
                            <el-select value="" v-model="artwork.theme" multiple filterable allow-create collapse-tags
                                       default-first-option placeholder="Select">
                                <el-option v-for="theme in options('theme')" :key="theme.value" :label="theme.label"
                                           :value="theme.value"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :sm="8">
                        <el-form-item label="Select main colors">
                            <el-select value="" v-model="artwork.color" multiple filterable allow-create collapse-tags
                                       default-first-option placeholder="Colors">
                                <el-option v-for="color in options('color')" :key="color.value" :label="color.label"
                                           :value="color.value">
                                    <span :style="{float: 'left', marginRight: '10px', width: '30px',height: '30px',backgroundColor: color.value}"></span>
                                    {{ color.label }}
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :sm="8">
                        <el-form-item label="Artwork shape">
                            <el-select value="" v-model="artwork.shape" filterable allow-create collapse-tags
                                       default-first-option placeholder="Select shape">
                                <el-option v-for="shape in options('shape')" :key="shape.value" :label="shape.label"
                                           :value="shape.value"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-row>
                    <el-col :sm="5">
                        <el-form-item label="Width, cm" prop="width">
                            <el-input-number v-model="artwork.width" :min="0.1" :max="999" size="small"
                                             :precision="1"></el-input-number>
                        </el-form-item>
                    </el-col>
                    <el-col :sm="5">
                        <el-form-item label="Height, cm" prop="height">
                            <el-input-number v-model="artwork.height" :min="0.1" :max="999" size="small"
                                             :precision="1"></el-input-number>
                        </el-form-item>
                    </el-col>
                    <el-col :sm="5">
                        <el-form-item label="Depth,cm" prop="depth">
                            <el-input-number v-model="artwork.depth" :min="0.1" :max="999" size="small"
                                             :precision="1"></el-input-number>
                        </el-form-item>
                    </el-col>
                    <el-col :sm="5">
                        <el-form-item label="Weight, g" prop="weight">
                            <el-input-number v-model="artwork.weight" :min="1" :max="10000" size="small"
                                             :precision="0"></el-input-number>
                        </el-form-item>
                    </el-col>
                    <el-col :sm="4" style="margin-top: 50px;">
                        <el-form-item>
                            <el-checkbox v-model="artwork.optional_size" v-if="artwork.category === 'painting'">Has
                                frame
                            </el-checkbox>
                            <el-checkbox v-model="artwork.optional_size" v-if="artwork.category === 'sculpture'">Has
                                base
                            </el-checkbox>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-row v-if="artwork.optional_size">
                    <el-col :sm="5">
                        <el-form-item label="Total Width, cm" prop="b_width">
                            <el-input-number v-model="artwork.b_width" :min="0.1" :max="999" size="small"
                                             :precision="1"></el-input-number>
                        </el-form-item>
                    </el-col>
                    <el-col :sm="5">
                        <el-form-item label="Total Height, cm" prop="b_height">
                            <el-input-number v-model="artwork.b_height" :min="0.1" :max="999" size="small"
                                             :precision="1"></el-input-number>
                        </el-form-item>
                    </el-col>
                    <el-col :sm="5">
                        <el-form-item label="Total Depth,cm" prop="b_depth">
                            <el-input-number v-model="artwork.b_depth" :min="0.1" :max="999" size="small"
                                             :precision="1"></el-input-number>
                        </el-form-item>
                    </el-col>
                    <el-col :sm="5">
                        <el-form-item label="Total Weight, g" prop="b_weight">
                            <el-input-number v-model="artwork.b_weight" :min="1" :max="10000" size="small"
                                             :precision="0"></el-input-number>
                        </el-form-item>
                    </el-col>

                </el-row>

                <el-row :gutter="20">
                    <el-col :sm="8">
                        <el-form-item label="Tags">
                            <el-select value="" v-model="artwork.tags" multiple filterable allow-create collapse-tags
                                       default-first-option placeholder="Select tags">
                                <el-option v-for="tag in artwork.tags" :key="tag" :label="tag"
                                           :value="tag"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                </el-row>


            </el-card>

            <el-card style="margin-bottom: 20px;">
                <div slot="header">Inventory and pricing</div>

                <el-row :gutter="20">
                    <el-col :sm="12">
                        <el-form-item label="Price, Eur" required prop="price">
                            <el-input-number value="2" v-model="artwork.price" :min="1" :max="50000"
                                             @blur="countPrice"></el-input-number>

                            <!--<span class="h5" style="padding-left: 10px;">{{ nettoIncome }}</span>-->
                            <!--<el-select value="" v-model="artwork.currency" placeholder="Select currency"-->
                            <!--style="max-width: 200px;margin-left: 20px;">-->
                            <!--<el-option v-for="(label, value) in currencies" :key="value" :value="value"-->
                            <!--:label="value"></el-option>-->
                            <!--</el-select>-->
                        </el-form-item>

                    </el-col>
                </el-row>

                <!--<el-row :gutter="20">-->
                <!--<el-col :sm="8">-->
                <!--<el-form-item label="How many Quantity?" prop="quantity">-->
                <!--<el-input-number :value="artwork.quantity ? artwork.quantity : 1" :min="1" :precision="0"-->
                <!--v-model="artwork.quantity"></el-input-number>-->
                <!--</el-form-item>-->
                <!--</el-col>-->

                <!--</el-row>-->

                <el-row :gutter="20" style="display: none;">

                    <el-col :sm="8">
                        <el-form-item label="Mark artwork as sold">
                            <el-checkbox v-model="artwork.sold" @click="">Sold</el-checkbox>
                        </el-form-item>
                    </el-col>

                    <el-col :sm="8">
                        <el-switch
                                v-model="artwork.available"
                                active-text="Artwork available for sale"
                                inactive-text="Temporary unavailable">
                        </el-switch>
                    </el-col>
                </el-row>


            </el-card>

            <el-card style="margin-bottom: 20px;display: none;">
                <div slot="header">Auction settings</div>

                <el-row :gutter="20" style="margin-bottom: 20px;">
                    <el-col :sm="8">
                        <el-form-item label="Your artworks can be sold on auction">
                            <el-checkbox v-model="artwork.auction_status" border>Place for auction</el-checkbox>
                        </el-form-item>
                    </el-col>

                    <el-col :sm="8">
                        <el-form-item label="Auction end date">
                            <el-date-picker
                                    v-model="artwork.auction_end"
                                    type="datetime"
                                    value-format="yyyy-MM-dd HH:mm:ss"
                                    placeholder="Select date and time">
                            </el-date-picker>
                        </el-form-item>
                    </el-col>

                    <el-col :sm="8" v-if="artwork.auction_status">
                        <el-form-item label="Starting price on auction ( EUR )">
                            <el-input-number value="2" v-model="artwork.auction_price" :min="1"
                                             :max="50000"></el-input-number>
                        </el-form-item>
                    </el-col>

                </el-row>

            </el-card>

            <el-card style="margin-bottom: 20px;">
                <div slot="header">Shipping</div>

                <el-row :gutter="20" style="margin-bottom: 20px;">
                    <el-col :sm="8">
                        <el-form-item label="Shipping origin" required prop="country_id">
                            <el-select filterable value="artwork.country_id" v-model="artwork.country_id"
                                       placeholder="Select country">
                                <el-option
                                        v-for="country in countries"
                                        :key="country.id"
                                        :label="country.country_name"
                                        :value="country.id">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-row :gutter="20" style="margin-bottom: 20px;">
                    <el-col :sm="8">
                        <el-form-item label="Processing time" required prop="processing_time">
                            <el-select filterable value="artwork.processing_time" v-model="artwork.processing_time"
                                       placeholder="Select your processing time">
                                <el-option v-for="time in options('processing-time')" :key="time.value"
                                           :label="time.label"
                                           :value="time.value"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                </el-row>

            </el-card>

            <!--<div class="app&#45;&#45;fixed-bottom">-->
            <!--<div class="app&#45;&#45;wrapper">-->

            <div class="bottom" style="text-align: right;">
                <span style="margin-right: 20px;">
                    {{ errorString }}
                </span>

                <el-button type="success" v-if="artwork_">
                    <a :href="artwork.url" target="_blank">Preview</a>
                </el-button>

                <el-button type="primary" @click="saveArtwork" :loading="loading">Save and Continue</el-button>

            </div>

            <!--</div>-->
            <!--</div>-->


        </el-form>
    </div>
</template>

<script>


    export default {

        props: {
            artwork_: {},
            currencies_: {},
        },

        data() {
            return {
                user: {},
                countries: [],
                csrf: window.csrf,
                currencies: [],
                artwork: {
                    medium: [],
                    tags: [],
                    direction: [],
                    theme: [],
                    color: [],
                    images: [],
                    image: [],
                },
                rules: {
                    image: [
                        {
                            required: true,
                            message: 'Please upload at least one photo of your artwork',
                            trigger: ['blur', 'change']
                        },
                    ],
                    name: [
                        {required: true, message: 'Please enter the name of artwork', trigger: ['submit']},
                    ],
                    made_by: [
                        {required: true, message: 'This field is required', trigger: ['submit']},
                    ],
                    date_of_completion: [
                        {required: true, message: 'This field is required', trigger: ['submit']},
                    ],
                    category: [
                        {required: true, message: 'Please select category', trigger: ['submit']}
                    ],
                    description: [
                        {required: true, message: 'This field is required', trigger: ['submit']},
                    ],
                    price: [
                        {required: true, message: 'Artwork price is required', trigger: ['submit']}
                    ],
                    // quantity: [
                    //     {required: true, message: 'Artwork quantity is required', trigger: ['submit']}
                    // ],
                    country_id: [
                        {required: true, message: 'Select shipping country', trigger: ['submit']}
                    ],
                    processing_time: [
                        {required: true, message: 'Select your processing time', trigger: ['submit']}
                    ]
                },

                artworkSaved: false,
                loading: false,
                nettoIncome: 0,
                totalPrice: 0,
                dialogImageUrl: '',
                dialogVisible: false,
                errorString: '',
                images: [],
            }
        },


        mounted() {

            axios.get('/api/profile').then(response => {
                    console.log(response);
                    this.user = response.data;
                }
            ).catch(error => {
                    console.log(error.response);
                }
            );

            if (this.artwork_) {
                this.artwork = JSON.parse(this.artwork_);
                this.artwork.image = [this.artwork.image];
            }

            if (this.currencies_) {
                this.currencies = JSON.parse(this.currencies_);
            }

            axios.get('/api/countries').then(response => {
                this.countries = response.data;
            });

            // this.countPrice();

        },

        methods: {

            countPrice() {
                this.nettoIncome = this.artwork.price / 100 * 75 + ' Eur'
            },

            saveArtwork() {

                // this.artwork.images =

                console.log(this.images);
                console.log(this.artwork.images);

                this.$refs['artwork'].validate((valid) => {
                    if (valid) {
                        // this.loading = true;

                        axios.post('/api/artwork/', this.artwork)
                            .then((response) => {
                                console.log(response.data);
                                // window.location.pathname = '/dashboard/artworks';
                            }).catch(error => {
                            console.log(error.response);
                            this.loading = false;
                        });
                    } else {
                        this.errorString = 'Some fields are still required'
                    }
                });

            },
            storeImageList(filelist) {
                this.artwork.images = filelist.map(image => {
                    if(image.response) {
                        return image.response.data;
                    } else {
                        return image;
                    }
                });
            },
            handleRemoveImages(file, fileList) {
               this.storeImageList(fileList);
            },
            handleRemoveImage(file, fileList) {
                this.artwork.image = [];
                this.artwork.image_id = null;
            },

            handlePictureCardPreview(file) {
                this.dialogImageUrl = file.url;
                this.dialogVisible = true;
            },

            handleImagesSuccess(response, file, fileList) {
                this.storeImageList(fileList);
            },

            handleImageSuccess(response, file) {
                console.log(response.data);
                this.artwork.image = [response.data];
                this.artwork.image_id = response.data.id;
            },

            beforeImageUpload(file) {
                console.log(file);
                const isJPG = file.type === 'image/jpeg' || file.type === 'image/jpg';
                const isLt2M = file.size / 1024 / 1024 < 10;

                if (!isJPG) {
                    this.$message.error('Image picture must be JPG or JPEG format!');
                }
                if (!isLt2M) {
                    this.$message.error('Image picture size can not exceed 10MB!');
                }
                return isJPG && isLt2M;
            },
        },
        computed: {
            showArtworkQuantity() {
                return this.artwork.unique;
            },
        }
    }
</script>