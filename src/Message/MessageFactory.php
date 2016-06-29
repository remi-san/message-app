<?php

namespace MessageApp\Message;

use MessageApp\Message\TextExtractor\MessageTextExtractor;
use MessageApp\User\ApplicationUser;
use MessageApp\User\UndefinedApplicationUser;
use RemiSan\Intl\ResourceTranslator;

class MessageFactory
{
    /**
     * @var MessageTextExtractor
     */
    private $extractor;

    /**
     * @var ResourceTranslator
     */
    private $resourceTranslator;

    /**
     * Constructor.
     *
     * @param MessageTextExtractor $extractor
     * @param ResourceTranslator   $resourceTranslator
     */
    public function __construct(MessageTextExtractor $extractor, ResourceTranslator $resourceTranslator)
    {
        $this->extractor = $extractor;
        $this->resourceTranslator = $resourceTranslator;
    }

    /**
     * @param  ApplicationUser[] $users
     * @param  object            $object
     * @param  string            $language
     * @return DefaultMessage
     */
    public function buildMessage(array $users, $object, $language = null)
    {
        $filteredUsers = self::filterUsers($users);

        if (count($filteredUsers) === 0) {
            return null;
        }

        $messageResource = $this->extractor->extractMessage($object);

        if ($messageResource === null) {
            return null;
        }

        $language = ($language) ? : self::getLanguage($filteredUsers);

        try {
            $translatedText = $this->resourceTranslator->translate($language, $messageResource);
        } catch (\IntlException $e) {
            $translatedText = $messageResource->getKey();
        }

        return new DefaultMessage($filteredUsers, $translatedText);
    }

    /**
     * @param  ApplicationUser[] $users
     * @return ApplicationUser[]
     */
    private static function filterUsers(array $users)
    {
        return array_values(
            array_unique(
                array_filter($users, function (ApplicationUser $user = null) {
                    return $user !== null && !$user instanceof UndefinedApplicationUser;
                })
            )
        );
    }

    /**
     * @param  ApplicationUser[] $users
     * @return string
     */
    private static function getLanguage(array $users)
    {
        return $users[0]->getPreferredLanguage();
    }
}
