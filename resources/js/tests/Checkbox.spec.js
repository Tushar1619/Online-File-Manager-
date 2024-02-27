import { describe, it, expect } from 'vitest';
import { render, screen } from '@testing-library/vue';
import userEvent from '@testing-library/user-event';
// import '@testing-library/jest-dom';

import * as matchers from '@testing-library/jest-dom/matchers';
expect.extend(matchers);

import Checkbox from '../Components/Checkbox.vue';
describe('Checkbox Input', () => {
  it('renders checkbox input and responds to user interactions', async () => {
    // Render the CheckboxInput component
    const { emitted } = render(Checkbox, {
      props: {
        checked: true,
        value: 'checkbox-value'
      }
    });

    // Check if the checkbox input is rendered
    const checkboxInput = screen.getByRole('checkbox');

    // Assert that the checkbox is checked initially
    expect(checkboxInput).toBeChecked();

    // Uncheck the checkbox
    await userEvent.click(checkboxInput);

    // Assert that the checkbox is unchecked after click
    expect(checkboxInput).not.toBeChecked();

    // Check if the emitted event is correct
    expect(emitted()).toHaveProperty('update:checked');
    expect(emitted()['update:checked']).toHaveLength(1);
    expect(emitted()['update:checked'][0]).toEqual([false]);
  });
});
