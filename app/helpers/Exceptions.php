<?php

class BeehiveNotFoundException extends Exception {}
class BeehiveException extends Exception {}
class BeehiveRestException extends Exception {
    const INVALID_TOKEN = 1;
    const EXPIRED_TOKEN = 2;
    const UNAUTHORIZED_TOKEN = 4;
}
// class FileNotFoundException extends Exception {}
// class ProjectNotFoundException extends Exception {}
// class EventNotFoundException extends Exception {}
// class TimesheetEntryNotFoundException extends Exception {}
// class UserNotFoundException extends Exception {}
// class NotAuthorizedForTaskException extends Exception {}
// class NotAuthorizedForProject extends Exception {}
// class NotAuthorizedForEventException extends Exception {}
// class NotAuthorizedForTimesheetEntryException extends Exception {}
// class SomeThingWentWrongException extends Exception {}

