import { mount } from '@vue/test-utils';
import Comments from '../resources/js/Comments.vue';

describe('Comments', () => {
  it('renders the correct number of comments', () => {
    const comments = [
      {
        id: 1,
        body: 'This is the first comment',
        user: {
          name: 'John Doe',
          profile_photo_url: 'https://example.com/profile.jpg',
        },
        created_at: '2022-02-08T12:00:00Z',
      },
      {
        id: 2,
        body: 'This is the second comment',
        user: {
          name: 'Jane Doe',
          profile_photo_url: 'https://example.com/profile.jpg',
        },
        created_at: '2022-02-08T13:00:00Z',
      },
    ];

    const wrapper = mount(Comments, {
      props: {
        commentable: {
          comments,
        },
        commentable_type: 'post',
      },
    });

    expect(wrapper.findAll('.p-6')).toHaveLength(comments.length);
  });

  it('calls the deleteComment method when the delete button is clicked', async () => {
    const comments = [
      {
        id: 1,
        body: 'This is the first comment',
        user: {
          name: 'John Doe',
          profile_photo_url: 'https://example.com/profile.jpg',
        },
        created_at: '2022-02-08T12:00:00Z',
      },
    ];

    const wrapper = mount(Comments, {
      props: {
        commentable: {
          comments,
        },
        commentable_type: 'post',
      },
    });

    const deleteCommentSpy = jest.spyOn(wrapper.vm, 'deleteComment');

    await wrapper.find('.btn-secondary').trigger('click');

    expect(deleteCommentSpy).toHaveBeenCalled();
  });
});