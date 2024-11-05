<div id="pricing" class="tab-content rounded-lg border bg-white shadow-sm">
    <div class="flex flex-col space-y-1.5 p-6">
        <h3 class="text-2xl font-semibold leading-none tracking-tight">Pricing Tiers</h3>
    </div>
    <div class="p-6 pt-0">
        <form id="pricing-form" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label for="hourly-rate"
                        class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Hourly
                        Rate</label>
                    <input id="hourly-rate" name="hourlyRate" type="number" placeholder="Enter hourly rate"
                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" />
                </div>
                <div class="space-y-2">
                    <label for="daily-rate"
                        class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Daily
                        Rate</label>
                    <input id="daily-rate" name="dailyRate" type="number" placeholder="Enter daily rate"
                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" />
                </div>
            </div>
            <button type="submit"
                class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-blue-500 text-white hover:bg-blue-600 h-10 px-4 py-2">Update
                Pricing</button>
        </form>
    </div>
</div>