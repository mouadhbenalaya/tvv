<?php

declare(strict_types=1);

namespace App\Domain\Users\Console\Commands;

use App\Common\Models\Country;
use App\Domain\Users\Models\Profile;
use App\Domain\Users\Models\User;
use App\Domain\Users\Models\UserType;
use App\Domain\Users\Rules\PasswordRule;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        do {
            $inputData['first_name'] = $this->ask('Enter the user\'s first name (required)', '');
        } while (strlen($inputData['first_name']) < 3);
        $inputData['second_name'] = $this->ask('Enter the user\'s second name');
        $inputData['third_name'] = $this->ask('Enter the user\'s third name');
        do {
            $inputData['last_name'] = $this->ask('Enter the user\'s last name (required)', '');
        } while (strlen($inputData['last_name']) < 3);
        do {
            $inputData['email'] = $this->ask('Enter the user\'s email address (required, unique)');
        } while (filter_var($inputData['email'], FILTER_VALIDATE_EMAIL) === false || User::where('email', $inputData['email'])->first());
        do {
            $inputData['id_number'] = $this->ask('Enter the user\'s id number (required, unique)', '');
        } while (strlen($inputData['id_number']) < 3 || User::where('id_number', $inputData['id_number'])->first());
        do {
            $inputData['mobile_number'] = $this->ask('Enter the user\'s mobile number (required)', '');
        } while (strlen($inputData['mobile_number']) < 3);
        $inputData['lives_in_saudi_arabi'] = $this->choice('Does user lives in Saudi Arabia?', ['false', 'true']);
        $inputData['country_name'] = $this->choice('Select an country:', Country::select('name')->pluck('name')->toArray());
        $inputData['user_type_title'] = $this->choice('Select user type:', UserType::select('name')->pluck('name')->toArray());
        do {
            $inputData['password'] = (string)$this->secret('Enter the user\'s password (min length: 8)');
        } while (strlen($inputData['password']) < 8);

        $validator = $this->validateInput($inputData);

        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $errors) {
                foreach ($errors as $error) {
                    $this->error($error);
                }
            }
            return Command::FAILURE;
        }

        if ($this->confirm('Do you want to create the user with the provided information?')) {
            try {
                $validated = $validator->validated();
                $userTypeId = $validated['user_type_id'];
                unset($validated['user_type_id']);
                $user = User::create($validated);
                Profile::create([
                    'user_id' => $user->id,
                    'user_type_id' => $userTypeId,
                ]);

                $this->info('User created successfully!');
                $this->line('User ID: ' . $user->id);
            } catch (ValidationException $exception) {
                $this->error($exception->getMessage());
                return Command::FAILURE;
            }
        } else {
            $this->info('User creation canceled.');
        }

        return Command::SUCCESS;
    }

    private function validateInput(array $inputData): \Illuminate\Validation\Validator
    {
        $data = $inputData;
        $data['lives_in_saudi_arabi'] = $data['lives_in_saudi_arabi'] === 'true';
        $data += [
            'country_id' => Country::where('name', $inputData['country_name'])->first()?->id,
            'user_type_id' => UserType::where('name', $inputData['user_type_title'])->first()?->id,
            'password' => Hash::make($inputData['password']),
        ];
        return Validator::make($data, [
            'first_name' => ['string', 'required'],
            'second_name' => ['string', 'nullable'],
            'third_name' => ['string', 'nullable'],
            'last_name' => ['string', 'required'],
            'email' => ['string', 'required', 'email', Rule::notIn(User::select('email')->pluck('email'))],
            'id_number' => ['string', 'required', Rule::notIn(User::select('id_number')->pluck('id_number'))],
            'mobile_number' => ['string', 'required'],
            'lives_in_saudi_arabi' => ['boolean', Rule::in([true, false]), 'required'],
            'country_id' => ['integer', 'required', Rule::in(Country::select('id')->pluck('id'))],
            'user_type_id' => ['integer', 'required', Rule::in(UserType::select('id')->pluck('id'))],
            'password' => ['string', 'required', new PasswordRule()],
        ]);
    }
}
