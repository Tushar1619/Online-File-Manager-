import { describe, it, expect } from 'vitest';
import { render, screen } from '@testing-library/vue';
import userEvent from '@testing-library/user-event';
import '@testing-library/jest-dom';

import * as matchers from '@testing-library/jest-dom/matchers';
expect.extend(matchers);

import InputLabel from '../Components/InputLabel.vue';

describe('Input Label', () => {
  it('renders value prop when provided', async () => {
    // Render the Label component with a value prop
    render(InputLabel, {
      props: {
        value: 'Label Text'
      }
    });

    // Check if the label contains the provided value
    const label = screen.getByText('Label Text');
    expect(label).toBeInTheDocument();
  });

  it('renders slot content when value prop is empty or undefined', async () => {
    // Render the Label component with empty value prop
    render(InputLabel, {
      props: {
        value: ''
      },
      slots: {
        default: 'Slot Text' // Slot content
      }
    });

    // Check if the label contains the slot content
    const label = screen.getAllByText('Slot Text');
    expect(label[0]).toBeInTheDocument();

    // Re-render the component with undefined value prop
    await render(InputLabel, {
      props: {
        value: undefined
      },
      slots: {
        default: 'Slot Text' // Slot content
      }
    });

    // Check if the label contains the slot content
    expect(screen.getAllByText('Slot Text')[0]).toBeInTheDocument();
  });
});


