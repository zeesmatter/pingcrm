<template>
  <div>
    <Head title="Create Type" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/types">Types</Link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="Name" />
          <select-input v-model="form.resource_name" :error="form.errors.resource_name" class="pb-8 pr-6 w-full lg:w-1/2" label="Resource Name">
            <option :value="null" />
            <option value="products">Products</option>
            <option value="customers">Customers</option>
          </select-input>
          <select-input v-model="form.parent_id" :error="form.errors.parent_id" class="pb-8 pr-6 w-full lg:w-1/2" label="Parent">
            <option :value="null" />
            <option v-for="type in types" :value="type.id">{{type.name }}</option>
          </select-input>
        </div>
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Type</loading-button>
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
    types: Array,
  },
  layout: Layout,
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: null,
        resource_name: null,
        parent_id: null
      }),
    }
  },
  methods: {
    store() {
      this.form.post('/types')
    },
  },
}
</script>
