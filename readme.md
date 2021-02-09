# AirLST Laravel SDK Package

## Usage

### Example of general retrieve and work of a worker (using guestlists for this example)

```php
use AirLST\Core\Facades\AirLSTCoreApi;

$apiWorker = AirLSTCoreApi::guestlist();

// Retrieve a single guestlist
$singleGuestlist = $apiWorker->find($id);

// Create a new guestlist
$newCreatedGuestlist = $apiWorker->create($id, ['name' => 'New guestlist']);

// Update a existing guestlist
$updatedGuestlist = $apiWorker->create($id, ['name' => 'Updated guestlist']);

// Archive a guestlist
$archivedGuestlist = $apiWorker->archive($id);

// Restore a archived guestlist
$restoredGuestlist = $apiWorker->restore($id);

// Permanently delete a guestlist
$guestlistIsDelete = $apiWorker->delete($id);
```

## Current available workers

| Facade function | Worker class |
|----|----|
| `AirLSTCoreApi::contact()` | `\AirLST\CoreSdk\Api\Workers\ContactWorker` |
| `AirLSTCoreApi::guestlist()` | `\AirLST\CoreSdk\Api\Workers\GuestlistWorker` |
| `AirLSTCoreApi::rsvp()` | `\AirLST\CoreSdk\Api\Workers\RsvpWorker` |
