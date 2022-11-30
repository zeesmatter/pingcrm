<template>
  <div>
    <Head title="Create Contact" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/memberships">Memberships</Link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="Name" />

          <text-input v-model="form.price" :error="form.errors.price" class="pb-8 pr-6 w-full lg:w-1/2" label="Price" />

          <text-input v-model="form.period" :error="form.errors.period" class="pb-8 pr-6 w-full lg:w-1/2" label="Period" />

          <toggle label="Trial Allowed" v-model="form.trial_allowed" :error="form.errors.allowed" class="pb-8 pr-6 w-full lg:w-1/2"/>

          <toggle label="Status" v-model="form.status" :error="form.errors.status" class="pb-8 pr-6 w-full lg:w-1/2"/>



        </div>
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Contact</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import Toggle from '@/Shared/Toggle'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    Toggle
  },
  layout: Layout,
  props: {
    organizations: Array,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: '',
        price: '',
        trial_allowed: true,
        period: '',
        status: false,
      }),
    }
  },
  methods: {
    store() {
      this.form.post('/memberships')
    },
  },
}
</script>
