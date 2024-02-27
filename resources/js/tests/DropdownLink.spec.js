import { describe, it, expect } from 'vitest';
import { render, screen } from '@testing-library/vue';
import userEvent from '@testing-library/user-event';
import '@testing-library/jest-dom';

import * as matchers from '@testing-library/jest-dom/matchers';
expect.extend(matchers);

import DropdownLink from '../Components/DropdownLink.vue';

describe('Dropdown Link', () => {
  it('renders link with correct href attribute', async () => {
    // Define the props
    const props = {
      href: 'https://example.com'
    };

    // Render the Link component with the provided props
    render(DropdownLink, {
      props
    });

    // Get the link element by its role
    const link = screen.getByRole('link');

    // Assert that the link has the correct href attribute
    expect(link).toHaveAttribute('href', 'https://example.com/');
  });

  it('renders link with default slot content', async () => {
    // Define the slot content
    const slotContent = 'Click me';

    // Render the Link component with the provided slot content
    render(DropdownLink, {
      slots: {
        default: slotContent
      }
    });

    // Get the link element by its role
    const link = screen.getByRole('link');

    // Assert that the link contains the slot content
    expect(link).toHaveTextContent(slotContent);
  });
});
