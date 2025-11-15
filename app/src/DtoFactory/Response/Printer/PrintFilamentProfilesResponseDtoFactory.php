<?php

namespace App\DtoFactory\Response\Printer;

use App\Dto\Response\Printer\PrintFilamentProfilesResponseDto;

final readonly class PrintFilamentProfilesResponseDtoFactory
{
    public function __construct(
        private PrintFilamentProfileDtoListFactory $printFilamentProfileDtoListFactory,
    ) {
    }

    public function create(array $data): PrintFilamentProfilesResponseDto
    {
        return new PrintFilamentProfilesResponseDto(
            $data['printer_profile'],
            $this->printFilamentProfileDtoListFactory->create($data['print_profiles']),
        );
    }
}
