import { describe, it, expect } from 'vitest';
import { render, screen } from '@testing-library/vue';
import userEvent from '@testing-library/user-event';
import '@testing-library/jest-dom';

import * as matchers from '@testing-library/jest-dom/matchers';
expect.extend(matchers);

import InputError from '../Components/InputError.vue';

describe('Input Error', () => {
  it('renders error message when message prop is provided', () => {
    // Render the ErrorMessage component with a message prop
    render(InputError, {
      props: {
        message: 'This is an error message'
      }
    });

    // Check if the error message is rendered
    const errorMessage = screen.getByText('This is an error message');
    expect(errorMessage).toBeInTheDocument();
  });

  it('renders nothing when message prop is empty or undefined', async () => {
    // Render the ErrorMessage component with an empty message prop
    render(InputError, {
      props: {
        message: ''
      }
    });

    // Check if the error message is hidden
    expect(screen.queryByText('This is an error message')).not.toBeInTheDocument();

    // Re-render the component with undefined message prop
    render(InputError, {
      props: {
        message: undefined
      }
    });

    // Check if the error message is hidden
    expect(screen.queryByText('This is an error message')).not.toBeInTheDocument();
  });
});
