<template>
  <div>
    <Head :title="form.name" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/types">Types</Link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="type.deleted_at" class="mb-6" @restore="restore"> This type has been deleted. </trashed-message>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="Name" />

          <select-input v-model="form.resource_name" :error="form.errors.resource_name" class="pb-8 pr-6 w-full lg:w-1/2" label="Resource Name">
            <option :value="null" />
            <option value="Products">Products</option>
            <option value="Customers">Customers</option>
          </select-input>

          <select-input v-model="form.parent_id" :error="form.errors.parent_id" class="pb-8 pr-6 w-full lg:w-1/2" label="Parent">
            <option :value="null" />
            <option v-for="type in types" :value="type.id">{{type.name }}</option>
          </select-input>

        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
<!--          <button v-if="!type.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Type</button>-->
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Type</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
  components: {
    Head,
    Icon,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
  },
  layout: Layout,
  props: {
    type: Object,
    types: Array,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: this.type.name,
        resource_name: this.type.resource_name,
        parent_id: this.type.parent,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(`/types/${this.type.id}`)
    },
    destroy() {
      if (confirm('Are you sure you want to delete this type?')) {
        this.$inertia.delete(`/types/${this.type.id}`)
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this type?')) {
        this.$inertia.put(`/types/${this.type.id}/restore`)
      }
    },
  },
}
</script>
