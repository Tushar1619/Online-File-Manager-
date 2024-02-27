import { describe, it, expect } from 'vitest';
import { render, screen, waitFor } from '@testing-library/vue';
import userEvent from '@testing-library/user-event';
import '@testing-library/jest-dom';

import * as matchers from '@testing-library/jest-dom/matchers';
expect.extend(matchers);

import TextInput from '../Components/TextInput.vue';

describe('TextInput', () => {
  // Test case: Input renders with initial value
  it('renders with initial value', () => {
    const initialValue = 'initial value';
    render(TextInput, {
      props: {
        modelValue: initialValue
      }
    });

    const inputElement = screen.getByRole('textbox');
    expect(inputElement).toHaveValue(initialValue);
  });

  // Test case: Input emits update event on value change
  it('emits update event on value change', async () => {
    const newValue = 'new value';
    const { emitted } = render(TextInput, {
      props: {
        modelValue: ''
      }
    });

    const inputElement = screen.getByRole('textbox');
    await userEvent.type(inputElement, newValue);

    expect(emitted()).toHaveProperty('update:modelValue');
    const emmitedValues = emitted()['update:modelValue'];
    expect(emmitedValues[emmitedValues.length-1]).toEqual([newValue]);
  });

});
