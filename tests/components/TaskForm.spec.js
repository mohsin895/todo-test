import { mount } from '@vue/test-utils'
import TaskForm from '@/views/components/TaskForm.vue'

describe('TaskForm.vue', () => {
  it('emits a "submit" event carrying title and body', async () => {
    const wrapper = mount(TaskForm)

    // fill in the form fields
    await wrapper.find('input[name="title"]').setValue('My Task')
    await wrapper.find('textarea[name="body"]').setValue('Task details')

    // submit the form
    await wrapper.find('form').trigger('submit.prevent')

    // assert that the submit event was emitted with the correct payload
    const emitted = wrapper.emitted('submit')
    expect(emitted).toBeTruthy()
    expect(emitted[0][0]).toEqual({
      title: 'My Task',
      body: 'Task details',
    })
  })
})
