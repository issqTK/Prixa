<template>
    <Head title="Create New Ads" />
    <div class="overflow-auto">
        <h1 class="text-2xl font-bold capitalize mb-6"> Create new Ads </h1>

        <form>
            <FirstParty 
                v-if="this.next == 1" 
                @product="(product) => this.form.product = product"
                :product="this.form.product"
                @city="(city) => this.form.city = city" 
                :city="this.form.city" 
                :errors="this.errors"
                :classes="classes"
            ></FirstParty>

            <SecondParty v-if="this.next == 2" @title="(title) => this.form.title = title"
                @description="(description) => this.form.description = description"
                @price="(price) => this.form.price = price" :title="this.form.title" :description="this.form.description"
                :price="this.form.price" :errors="this.errors"
                :classes="classes"></SecondParty>

            <ThirdParty v-if="this.next == 3" @file="(file) => this.form.images.push(file)" :errorEmpty="this.errors.image">
            </ThirdParty>

            <fourthParty v-if="this.next == 4" @update:phone="(phone) => this.form.phone = phone"
                @update:whatsapp="(whatsapp) => this.form.whatsapp = whatsapp"
                @update:shop="(shop) => this.form.shop = shop" :phone="this.form.phone" :whatsapp="this.form.whatsapp"
                :shop="this.form.shop" :errors="this.errors"
                :classes="classes"></fourthParty>

            <FifthParty v-if="this.next == 5" @update:fullName="(name) => this.form.fullName = name"
                @update:email="(email) => this.form.email = email"
                @update:password="(password) => this.form.password = password"
                @update:passwordConfirm="(passwordC) => this.form.passwordConfirm = passwordC"
                :fullName="this.form.fullName" :email="this.form.email" :errors="this.errors"
                :classes="classes"></FifthParty>
        </form>

        <div v-show="this.next == 6" class="md:w-10/12 px-4 py-6 text-center rounded mx-auto overflow-auto bg-white">
            <h2 class="text-base font-bold uppercase mb-4">processing your request...please wait</h2>
            <span class="w-4 h-4 table mx-auto rounded-full border-2 border-slate-700 border-dotted animate-spin"></span>
        </div>

        <btn @click="getNext" v-show="this.next != 6" class="mt-6 py-4 px-6 float-right">Next</btn>
        
        <btn @click="getPrevieus" 
            class="bg-slate-300 hover:bg-slate-400 mt-6 py-4 px-6 float-left">
            Back
        </btn>

    </div>
</template>

<script>
import FirstParty from '@/Pages/AdGuest/FirstParty.vue';
import SecondParty from '@/Pages/AdGuest/SecondParty.vue';
import ThirdParty from '@/Pages/AdGuest/ThirdParty.vue';
import fourthParty from '@/Pages/AdGuest/fourthParty.vue';
import FifthParty from '@/Pages/AdGuest/FifthParty.vue';
import btn from "@/Components/Button.vue";

import { Head, Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3'
import Layout from '@/Layouts/GuestLayout.vue';


export default {
    layout: Layout,
    components: {
        Head,
        Link,
        FirstParty,
        SecondParty,
        ThirdParty,
        fourthParty,
        FifthParty,
        btn
    },
    data() {
        return {
            next: 1,
            sendForm: true,

            classes: "focus:outline-none focus:border-none focus:ring-offset-0 focus:ring-2 focus:ring-cyan-400",

            form: useForm({
                product: null,
                city: null,
                title: null,
                description: null,
                price: null,
                slug: null,
                images: [],
                phone: null,
                whatsapp: '',
                shop: '',
                fullName: null,
                email: null,
                password: null,
                passwordConfirm: null
            }),

            errors: {
                product: null,
                city: null,
                title: null,
                description: null,
                price: null,
                image: null,
                phone: null,
                whatsapp: null,
                shop: null,
                fullName: null,
                email: null,
                password: null,
                passwordConfirm: null
            },
        }
    },
    methods: {
        getPrevieus() { this.next--; },

        async getNext() {
            const text = /^[a-zA-Z0-9À-ÿ-,:'.|/)( ]+$/,
                textarea = /^[a-zA-Z0-9À-ÿ\n-,:'.|/)( ]+$/,
                number = /^[0-9]+$/,
                phone = /^[0-9]{10}$/,
                fullName = /^[a-zA-ZÀ-ÿ ]+$/,
                email = /^\S+@\S+\.\S+$/,
                url_pattern = /(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g;

            if (this.next == 1) {

                if (this.form.product == null) {
                    this.errors.product = 'choosing product is required!';
                    return
                } else this.errors.product = null

                if (this.form.city == null) {
                    this.errors.city = 'choosing city is required!';
                    return
                } else this.errors.city = null

                this.next++;

            }
            else if (this.next == 2) {

                if (!text.test(this.form.title) || this.form.title == null) {
                    this.errors.title = 'title is required!';
                    return
                } else {
                    this.errors.title = null;
                    this.form.slug = this.form.title.trim().replace(/\s/g, "-").replace(/,/g, '').toLowerCase();
                }

                if (!textarea.test(this.form.description) || this.form.description == null) {
                    this.errors.description = 'description is required!';
                    return
                } else this.errors.description = null;

                if (!number.test(this.form.price)) {
                    this.errors.price = 'price is required!';
                    return
                } else this.errors.price = null;

                this.next++;
            }
            else if (this.next == 3) {
                if (this.form.images.length == 0) this.errors.image = 'you are required to upload pictures!';
                else {
                    this.errors.image = null;
                    this.next++;
                }
            }
            else if (this.next == 4) {

                if (!phone.test(this.form.phone)) {
                    this.errors.phone = 'phone is required! (10 digits)';
                    return;
                } else {
                    await axios
                        .get('/api/phone-already-exist/' + this.form.phone)
                        .then((response) => {
                            if (response.data.exist == true)
                                this.errors.phone = 'phone already exist!';
                            else this.errors.phone = null;
                        });
                }

                if (this.form.whatsapp.length > 0 && !phone.test(this.form.whatsapp)) {
                    this.errors.whatsapp = 'whatsapp optional! (10 digits)';
                    return;
                } else this.errors.whatsapp = null;

                if (this.form.shop.length > 0 && !url_pattern.test(this.form.shop)) {
                    this.errors.shop = 'shop url optional! (valid url)';
                    return;
                } else this.errors.shop = null;

                if (this.errors.phone == null) this.next++;
            }
            else if (this.next == 5) {

                if (!fullName.test(this.form.fullName) || this.form.fullName == null) {
                    this.errors.fullName = 'full name required!';
                    return
                } else this.errors.fullName = null;

                if (!email.test(this.form.email)) {
                    this.errors.email = 'email is required! (valid address email)';
                    return;
                } else {
                    await axios
                        .get('api/email-already-exist/' + this.form.email)
                        .then((response) => {
                            if (response.data.exist) {
                                this.errors.email = 'email already exist!';
                                return;
                            }
                            else this.errors.email = null;
                        });
                }

                if (this.form.password == null || this.form.password.length <= 7) {
                    this.errors.password = 'password is required! (minimum 7 characters)';
                    return;
                } else this.errors.password = null;

                if (this.form.passwordConfirm != this.form.password) {
                    this.errors.passwordConfirm = 'password confirmation does not match!';
                    return;
                } else this.errors.passwordConfirm = null;

                if (this.errors.email == null) this.next++;

            }

        },
    },
    updated() {
        if (this.next == 6 && this.sendForm == true) {

            this.form.post('/store-new-ads', {
                preserveScroll: true,
                preserveState: true,
            })

            this.sendForm = false;
        }
    }
}
</script>