<template>
  <div>
    <section class="bg-white dark:bg-gray-900 py-8 lg:py-16">
      <div class="max-w-2xl mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">Discussion ({{
              comments.length
            }})</h2>
        </div>


        <form class="mb-6" @submit.prevent="submit">
                    <textarea v-model="form.body" class="textarea textarea-primary w-full" placeholder="Your comment"
                              rows="6"></textarea>
          <button class="btn my-2 px-5" type="submit">Post comment</button>
        </form>


        <article v-for="comment in commentable.comments" :key="comment.id"
                 class="p-6 mb-6 bg-white text-base border-t border-gray-200 dark:border-gray-700 dark:bg-gray-900">
          <div class="flex justify-between items-center mb-2">
            <div class="flex items-center">
              <p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white">
                <img :alt="comment.user.name"
                     :src="comment.user.profile_photo_url"
                     class="mr-2 w-10 h-10 rounded-full object-cover"/>
                {{
                  comment.user.name
                }}</p>
              <p class="text-sm text-gray-600 dark:text-gray-400">
                <time datetime="2022-02-08"
                      title="February 8th, 2022">{{ comment.created_at }}
                </time>
              </p>
            </div>

          </div>
          <p class="text-gray-500 dark:text-gray-400">{{ comment.body }}</p>
          <div class="flex items-center mt-4 space-x-4">
            <button class="btn btn-sm btn-secondary gap-1"
                    type="button"
                    @click="deleteComment(comment)">
              <svg aria-hidden="true" class="mr-1 w-4 h-4" data-darkreader-inline-fill=""
                   data-darkreader-inline-stroke="" fill="none" stroke="currentColor" stroke-width="1.5"
                   viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                    stroke-linecap="round"
                    stroke-linejoin="round"></path>
              </svg>
              Delete
            </button>

          </div>
        </article>
      </div>
    </section>


  </div>
</template>

<script lang="ts" setup>
import {defineProps, ref, watch} from 'vue';
import {useForm, usePage} from '@inertiajs/vue3'
import route from 'ziggy-js';
import {useToast} from "vue-toastification";

interface PageProps {
  props: {
    jetstream: {
      flash: {
        message: string
      }
    }
  }

  [key: string]: any
}

interface CommentFormData {
  body: string;

  [key: string]: any
}

const page = usePage<PageProps>();


const props = defineProps({
  commentable: Object,
  commentable_type: String,
});


const toast = useToast();
const {post} = useForm<CommentFormData>({
  body: '',
});


interface Form {
  body: string;
  commentable_type: any;
  commentable_id: any;

  [key: string]: any
}

const form = useForm<Form>({
  body: '',
  commentable_type: props.commentable_type,
  commentable_id: props.commentable?.id || '',

});

let comments = ref(props.commentable?.comments || []);

//comments counter
watch(() => props.commentable?.comments, (value) => {
  comments.value = value as Comment[] | undefined;
});


const submit = () => {

  form.post(route('comments.store'), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
      toast.success(page.props.jetstream.flash.message);

    },
    onError: () => {
      toast.error('Error adding comment');
    },
  });
}

const deleteComment = (comment: { id: any; }) => {
  const options = {
    forceFormData: true,
    preserveScroll: true,
    onSuccess: () => {
      toast.success(page.props.jetstream.flash.message);
    },
    onError: () => {
      toast.error('Error deleting comment');
    },
  };

  form.delete(`/comments/${comment.id}`, options);


}


</script>
