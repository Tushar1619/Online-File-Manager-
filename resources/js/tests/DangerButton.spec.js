import { describe, it, expect } from 'vitest';
import { render, screen } from '@testing-library/vue';
import userEvent from '@testing-library/user-event';
import '@testing-library/jest-dom';

import * as matchers from '@testing-library/jest-dom/matchers';
expect.extend(matchers);

import DangerButton from '../Components/DangerButton.vue';

describe('Button', () => {
  it('renders button and responds to user interactions', async () => {
    // Render the Button component with some content
    const { emitted } = render(DangerButton, {
      slots: {
        default: 'Click me' // Slot content
      }
    });

    // Check if the button is rendered
    const button = screen.getByRole('button', { name: 'Click me' });

    // Simulate a user click on the button
    await userEvent.click(button);

    // Check if the button click event is emitted
    expect(emitted()).toHaveProperty('click');
    expect(emitted('click')).toHaveLength(1);
  });
});
