<script setup lang="ts">
interface Props {
  label: string
  modelValue: string | number
  error?: string
  type?: 'text' | 'number'
  name: string
}

interface Emits {
  (e: 'update:modelValue', value: string | number): void
  (e: 'input', name: string): void
}

const props = withDefaults(defineProps<Props>(), {
  type: 'text'
})

const emit = defineEmits<Emits>()

const handleInput = (event: Event) => {
  const target = event.target as HTMLInputElement
  let value: string | number = target.value
  
  // Convert to number if using v-model.number modifier or type is number
  if (props.type === 'number' || target.type === 'number') {
    value = target.value === '' ? 0 : Number(target.value)
  }
  
  emit('update:modelValue', value)
  emit('input', props.name)
}
</script>

<template>
  <div>
    <label class="label">{{ label }}</label>
    <input 
      :type="type"
      :value="modelValue"
      @input="handleInput"
      class="input" 
    />
    <div v-if="error" class="text-red-500 dark:text-red-400 text-xs">
      {{ error }}
    </div>
  </div>
</template>

<style scoped>
label {
  margin-right: 2em;
}

div {
  padding: 2px;
}
</style>
