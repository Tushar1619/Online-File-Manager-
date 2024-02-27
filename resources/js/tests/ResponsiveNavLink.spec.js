import { describe, it, expect } from 'vitest';
import { render, screen, waitFor } from '@testing-library/vue';
import userEvent from '@testing-library/user-event';
import '@testing-library/jest-dom';

import * as matchers from '@testing-library/jest-dom/matchers';
expect.extend(matchers);

import ResponsiveNavLink from '../Components/ResponsiveNavLink.vue';

describe('Responsive Nav Link', () => {
  // Test case: Link renders with provided href
  it('renders with provided href', () => {
    const href = '/some-path';
    render(ResponsiveNavLink, {
      props: {
        href
      }
    });
    const linkElement = screen.getByRole('link')
    // const linkElement = screen.getByTestId('custom-element'); // Adjust the name as needed
    expect(linkElement).toHaveAttribute('href', href);
  });

  // Test case: Link renders with active classes when active prop is true
  it('renders with active classes when active prop is true', () => {
    render(ResponsiveNavLink, {
      props: {
        active: true
      }
    });

    const linkElement = screen.getByRole('link'); // Adjust the name as needed
    expect(linkElement).toHaveClass('border-indigo-400');
    expect(linkElement).toHaveClass('text-indigo-700');
    // Add assertions for other active classes as needed
  });

  // Test case: Link renders with default classes when active prop is false
  it('renders with default classes when active prop is false', () => {
    render(ResponsiveNavLink, {
      props: {
        active: false
      }
    });

    const linkElement = screen.getByRole('link');
    expect(linkElement).toHaveClass('text-gray-600');
    expect(linkElement).toHaveClass('hover:text-gray-800');
    // Add assertions for other default classes as needed
  });
});
