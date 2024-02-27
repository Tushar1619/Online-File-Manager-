import { describe, it, expect } from 'vitest';
import { render, screen, waitFor } from '@testing-library/vue';
import userEvent from '@testing-library/user-event';
import '@testing-library/jest-dom';

import * as matchers from '@testing-library/jest-dom/matchers';
expect.extend(matchers);

import SecondaryButton from '../Components/SecondaryButton.vue';

describe('Secondary Button', () => {
  // Test case: Button renders with default type
  it('renders with default type', () => {
    render(SecondaryButton);

    const buttonElement = screen.getByRole('button');
    expect(buttonElement).toHaveAttribute('type', 'button');
  });

  // Test case: Button renders with default classes
  it('renders with default classes', () => {
    render(SecondaryButton);

    const buttonElement = screen.getByRole('button'); // Adjust the name as needed
    expect(buttonElement).toHaveClass('bg-white');
    expect(buttonElement).toHaveClass('border-gray-300');
  });
});
