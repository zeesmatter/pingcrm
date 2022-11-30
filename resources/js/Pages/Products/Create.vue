<template>
  <div>
    <Head title="Create Product" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/products">Products</Link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="w-full bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">

        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/3" label="Name" />

          <text-input v-model="form.description" :error="form.errors.description" class="pb-8 pr-6 w-full lg:w-2/3" label="Description" />

          <select-input v-model="form.types_id" :error="form.errors.types_id" class="pb-8 pr-6 w-full lg:w-1/3" label="Type">
            <option v-for="type in types" :value="type.id">{{type.name }}</option>
          </select-input>

          <select-input v-model="form.status" :error="form.errors.status" class="pb-8 pr-6 w-full lg:w-1/3" label="Status">
            <option value="draft">Draft</option>
            <option value="published">Published</option>
            <option value="unlisted">Unlisted</option>
          </select-input>

        </div>
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo" product="submit">Create Product</loading-button>
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

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
  },
  props: {
    products: Array,
    types: Array,
  },
  layout: Layout,
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: null,
        description: null,
        types_id: null,
        status: null,
      }),
    }
  },
  methods: {
    store() {
      this.form.post('/products')
    },
  },
}
</script>
