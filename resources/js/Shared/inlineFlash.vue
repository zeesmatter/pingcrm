<template>
  <Transition>
    <div class="bg-green-500 rounded p-2 mr-2 text-white" v-if="flash.success">{{ flash.success }}</div>
  </Transition>

</template>

<style>
.v-enter-active,
.v-leave-active {
  transition: opacity 1s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
</style>

<script>
export default {
  props: {
    flash: Object
  },
  watch: {
    flash: function() {

      let self = this;
      if(this.flash.success)
        setTimeout(function() {
          self.flash.success = false;
        }, 2000);

    }
  }
}
</script>
